<?php

class Checkout extends Controller {
    public function index()
    {
        $cartModel = $this->model('Cart_model');
        
        if($cartModel->isEmpty()) {
            header('Location: ' . BASEURL . '/cart');
            exit;
        }
        
        $data['title'] = 'Checkout - Sistem Order';
        $data['cart'] = $cartModel->getCart();
        $data['total'] = $cartModel->getTotal();
        $data['cart_count'] = $cartModel->getCartCount();
        $this->view('home/checkout', $data);
    }

    public function process()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cartModel = $this->model('Cart_model');
            
            if($cartModel->isEmpty()) {
                header('Location: ' . BASEURL);
                exit;
            }
            
            // Create order
            $orderData = [
                'nama_pelanggan' => $_POST['nama_pelanggan'],
                'no_telepon' => $_POST['no_telepon'],
                'catatan' => $_POST['catatan'] ?? '',
                'total_harga' => $cartModel->getTotal()
            ];
            
            $orderModel = $this->model('Order_model');
            $id_order = $orderModel->createOrder($orderData);
            
            // Get order with nomor_pesanan
            $order = $orderModel->getOrderById($id_order);
            
            // Add order details
            foreach($cartModel->getCart() as $item) {
                $orderModel->addOrderDetail(
                    $id_order,
                    $item['id_menu'],
                    $item['jumlah'],
                    $item['harga'] * $item['jumlah']
                );
            }
            
            $paymentModel = $this->model('Payment_model');
            $metode_bayar = $_POST['metode_bayar'];
            
            // Handle QRIS payment
            if ($metode_bayar === 'qris') {
                // Check if QRIS is supported (columns exist)
                $db = new Database();
                $db->query("SHOW COLUMNS FROM payment LIKE 'qris_string'");
                $hasQrisSupport = $db->single();
                
                if ($hasQrisSupport) {
                    require_once 'app/services/PakasirService.php';
                    $pakasirService = new PakasirService();
                    
                    $qrisResult = $pakasirService->createTransaction(
                        $order['nomor_pesanan'],
                        $cartModel->getTotal(),
                        'qris'
                    );
                    
                    if ($qrisResult['success']) {
                        $qrisData = [
                            'qris_string' => $qrisResult['data']['payment_number'],
                            'qris_expired' => $pakasirService->convertToMySQLDateTime($qrisResult['data']['expired_at']),
                            'pakasir_fee' => $qrisResult['data']['fee'],
                            'pakasir_total' => $qrisResult['data']['total_payment']
                        ];
                        
                        $paymentModel->createPayment($id_order, $metode_bayar, $qrisData);
                        
                        // Clear cart
                        $cartModel->clearCart();
                        
                        // Redirect to QRIS payment page dengan id_order di URL
                        $_SESSION['qris_payment'] = $id_order;
                        header('Location: ' . BASEURL . '/checkout/qris/' . $id_order);
                        exit;
                    } else {
                        // QRIS API failed, fallback to tunai
                        $paymentModel->createPayment($id_order, 'tunai');
                        Flasher::setFlash('QRIS tidak tersedia, silakan bayar tunai di tempat', '', 'warning');
                    }
                } else {
                    // QRIS not supported, fallback to tunai
                    $paymentModel->createPayment($id_order, 'tunai');
                    Flasher::setFlash('QRIS belum tersedia, silakan bayar tunai di tempat', '', 'info');
                }
            } else {
                // Create regular payment record
                $paymentModel->createPayment($id_order, $metode_bayar);
            }
            
            // Clear cart
            $cartModel->clearCart();
            
            // Redirect with success message (dengan id_order di URL)
            $_SESSION['order_success'] = $id_order;
            header('Location: ' . BASEURL . '/checkout/success/' . $id_order);
            exit;
        }
    }

    public function qris($id_order = null)
    {
        // Prioritas: parameter URL > session
        if ($id_order === null && isset($_SESSION['qris_payment'])) {
            $id_order = $_SESSION['qris_payment'];
            // Jangan unset session, biarkan untuk refresh
        }
        
        if ($id_order === null) {
            header('Location: ' . BASEURL);
            exit;
        }
        
        $orderModel = $this->model('Order_model');
        $paymentModel = $this->model('Payment_model');
        
        $order = $orderModel->getOrderById($id_order);
        $payment = $paymentModel->getPaymentByOrderId($id_order);
        
        if (!$order || !$payment || $payment['metode'] !== 'qris') {
            // Clear session jika order tidak valid
            unset($_SESSION['qris_payment']);
            header('Location: ' . BASEURL);
            exit;
        }
        
        // Jika sudah lunas, redirect ke success
        if ($payment['status_bayar'] === 'lunas') {
            unset($_SESSION['qris_payment']);
            $_SESSION['order_success'] = $id_order;
            header('Location: ' . BASEURL . '/checkout/success');
            exit;
        }
        
        // Check if expired
        if ($paymentModel->isQRISExpired($payment['id_payment'])) {
            // Clear session jika expired
            unset($_SESSION['qris_payment']);
            $data['title'] = 'Pembayaran QRIS Expired';
            $data['expired'] = true;
        } else {
            // Simpan session untuk refresh berikutnya
            $_SESSION['qris_payment'] = $id_order;
            
            require_once 'app/services/PakasirService.php';
            $pakasirService = new PakasirService();
            
            $data['title'] = 'Pembayaran QRIS';
            $data['expired'] = false;
            $data['qr_image'] = $pakasirService->generateQRCode($payment['qris_string']);
            $data['qr_services'] = $pakasirService->getQRCodeServices($payment['qris_string']);
            $data['remaining_time'] = $pakasirService->formatExpiredTime($payment['qris_expired']);
        }
        
        $data['order'] = $order;
        $data['payment'] = $payment;
        $data['cart_count'] = 0;
        $this->view('home/qris', $data);
    }

    // Method untuk akses halaman pembayaran via nomor pesanan
    public function payment($nomor_pesanan = null)
    {
        if ($nomor_pesanan === null) {
            header('Location: ' . BASEURL);
            exit;
        }
        
        $orderModel = $this->model('Order_model');
        $paymentModel = $this->model('Payment_model');
        
        // Cari order berdasarkan nomor pesanan
        $order = $orderModel->getOrderByNomor($nomor_pesanan);
        
        if (!$order) {
            Flasher::setFlash('Pesanan tidak ditemukan', '', 'danger');
            header('Location: ' . BASEURL);
            exit;
        }
        
        $payment = $paymentModel->getPaymentByOrderId($order['id_order']);
        
        if (!$payment) {
            Flasher::setFlash('Data pembayaran tidak ditemukan', '', 'danger');
            header('Location: ' . BASEURL);
            exit;
        }
        
        // Jika metode QRIS dan belum lunas, redirect ke halaman QRIS
        if ($payment['metode'] === 'qris' && $payment['status_bayar'] !== 'lunas') {
            $_SESSION['qris_payment'] = $order['id_order'];
            header('Location: ' . BASEURL . '/checkout/qris/' . $order['id_order']);
            exit;
        }
        
        // Jika sudah lunas, tampilkan halaman sukses
        if ($payment['status_bayar'] === 'lunas') {
            $_SESSION['order_success'] = $order['id_order'];
            header('Location: ' . BASEURL . '/checkout/success');
            exit;
        }
        
        // Untuk metode lain (tunai), tampilkan status
        $data['title'] = 'Status Pembayaran';
        $data['order'] = $order;
        $data['payment'] = $payment;
        $data['cart_count'] = 0;
        $this->view('home/payment_status', $data);
    }

    public function success($id_order = null)
    {
        // Prioritas: parameter URL > session
        if ($id_order === null && isset($_SESSION['order_success'])) {
            $id_order = $_SESSION['order_success'];
        }
        
        if ($id_order === null) {
            header('Location: ' . BASEURL);
            exit;
        }
        
        // Get order data
        $orderModel = $this->model('Order_model');
        $order = $orderModel->getOrderById($id_order);
        
        if (!$order) {
            unset($_SESSION['order_success']);
            header('Location: ' . BASEURL);
            exit;
        }
        
        // Simpan session untuk refresh (tapi dengan timeout)
        $_SESSION['order_success'] = $id_order;
        
        $data['title'] = 'Pesanan Berhasil - Sistem Order';
        $data['id_order'] = $id_order;
        $data['order'] = $order;
        $data['cart_count'] = 0;
        $this->view('home/success', $data);
    }

    public function webhook()
    {
        // Webhook handler untuk Pakasir
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method not allowed');
        }

        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (!$data) {
            http_response_code(400);
            exit('Invalid JSON');
        }

        // Log webhook untuk debugging
        error_log('Pakasir Webhook: ' . $input);

        // Validate required fields
        $required = ['amount', 'order_id', 'project', 'status', 'payment_method'];
        foreach ($required as $field) {
            if (!isset($data[$field])) {
                http_response_code(400);
                exit('Missing field: ' . $field);
            }
        }

        // Validate project - ambil dari database
        $pengaturanModel = $this->model('Pengaturan_model');
        $pakasirProject = $pengaturanModel->getPengaturanValue('pakasir_project');
        if (empty($pakasirProject)) {
            $pakasirProject = 'dapur-al-furqon'; // fallback default
        }
        
        if ($data['project'] !== $pakasirProject) {
            http_response_code(400);
            exit('Invalid project');
        }

        // Process webhook
        if ($data['status'] === 'completed') {
            $paymentModel = $this->model('Payment_model');
            $orderModel = $this->model('Order_model');
            
            $payment = $paymentModel->getPaymentByPakasirOrderId($data['order_id']);
            
            if ($payment) {
                // Validate amount
                if ((int)$data['amount'] !== (int)$payment['total_harga']) {
                    error_log('Amount mismatch: webhook=' . $data['amount'] . ', order=' . $payment['total_harga']);
                    http_response_code(400);
                    exit('Amount mismatch');
                }
                
                // Update payment status
                $paymentModel->updatePaymentStatusByOrderId($payment['id_order'], 'lunas');
                
                // Update order status
                $orderModel->updateOrderStatus($payment['id_order'], 'selesai');
                
                http_response_code(200);
                exit('OK');
            } else {
                error_log('Payment not found for order_id: ' . $data['order_id']);
                http_response_code(404);
                exit('Payment not found');
            }
        }

        http_response_code(200);
        exit('OK');
    }

    public function check_payment($id_order)
    {
        // AJAX endpoint untuk cek status pembayaran
        header('Content-Type: application/json');
        
        $paymentModel = $this->model('Payment_model');
        $payment = $paymentModel->getPaymentByOrderId($id_order);
        
        if (!$payment) {
            echo json_encode(['status' => 'not_found']);
            exit;
        }
        
        $response = [
            'status' => $payment['status_bayar'],
            'expired' => $paymentModel->isQRISExpired($payment['id_payment'])
        ];
        
        echo json_encode($response);
        exit;
    }
}
