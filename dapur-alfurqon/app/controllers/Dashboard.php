<?php

class Dashboard extends Controller {
    public function __construct()
    {
        if(!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL);
            exit;
        }
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['nama'] = $_SESSION['nama_lengkap'];
        $this->view('dashboard/index', $data);
    }

    // ==================== MENU ====================
    public function menu($action = 'index', $id = null)
    {
        switch($action) {
            case 'tambah':
                $data['title'] = 'Tambah Menu';
                $this->view('menu/tambah', $data);
                break;
            case 'edit':
                $data['title'] = 'Edit Menu';
                $data['menu'] = $this->model('Menu_model')->getMenuById($id);
                $this->view('menu/edit', $data);
                break;
            case 'simpan':
                $this->menuSimpan();
                break;
            case 'update':
                $this->menuUpdate();
                break;
            case 'hapus':
                $this->menuHapus($id);
                break;
            default:
                $data['title'] = 'Daftar Menu';
                $data['menu'] = $this->model('Menu_model')->getAllMenu();
                $this->view('menu/index', $data);
        }
    }

    private function menuSimpan()
    {
        $gambar = $this->model('Menu_model')->upload();
        if( !$gambar ) {
            return false;
        }

        $data = [
            'nama_menu' => $_POST['nama_menu'],
            'kategori' => $_POST['kategori'],
            'harga' => $_POST['harga'],
            'deskripsi' => $_POST['deskripsi'],
            'status' => $_POST['status'],
            'gambar' => $gambar
        ];

        if( $this->model('Menu_model')->tambahMenu($data) > 0 ) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success');
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'error');
        }
        header('Location: ' . BASEURL . '/dashboard/menu');
        exit;
    }

    private function menuUpdate()
    {
        $gambarLama = $_POST['gambarLama'];
        
        if( $_FILES['gambar']['error'] === 4 ) {
            $gambar = $gambarLama;
        } else {
            $gambar = $this->model('Menu_model')->upload();
        }

        $data = [
            'id_menu' => $_POST['id_menu'],
            'nama_menu' => $_POST['nama_menu'],
            'kategori' => $_POST['kategori'],
            'harga' => $_POST['harga'],
            'deskripsi' => $_POST['deskripsi'],
            'status' => $_POST['status'],
            'gambar' => $gambar
        ];

        if( $this->model('Menu_model')->ubahMenu($data) > 0 ) {
            Flasher::setFlash('berhasil', 'diubah', 'success');
        } else {
            Flasher::setFlash('gagal', 'diubah', 'error');
        }
        header('Location: ' . BASEURL . '/dashboard/menu');
        exit;
    }

    private function menuHapus($id)
    {
        if( $this->model('Menu_model')->hapusMenu($id) > 0 ) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'error');
        }
        header('Location: ' . BASEURL . '/dashboard/menu');
        exit;
    }

    // ==================== KARYAWAN ====================
    public function karyawan($action = 'index', $id = null)
    {
        switch($action) {
            case 'tambah':
                $data['title'] = 'Tambah Karyawan';
                $this->view('karyawan/tambah', $data);
                break;
            case 'edit':
                $data['title'] = 'Edit Karyawan';
                $data['karyawan'] = $this->model('Karyawan_model')->getKaryawanById($id);
                $this->view('karyawan/edit', $data);
                break;
            case 'simpan':
                $this->karyawanSimpan();
                break;
            case 'update':
                $this->karyawanUpdate();
                break;
            case 'hapus':
                $this->karyawanHapus($id);
                break;
            default:
                $data['title'] = 'Daftar Karyawan';
                $data['karyawan'] = $this->model('Karyawan_model')->getAllKaryawan();
                $this->view('karyawan/index', $data);
        }
    }

    private function karyawanSimpan()
    {
        $foto = $this->model('Karyawan_model')->upload();
        if( !$foto ) {
            return false;
        }

        $data = [
            'nama' => $_POST['nama'],
            'jabatan' => $_POST['jabatan'],
            'status' => $_POST['status'],
            'foto' => $foto
        ];

        if( $this->model('Karyawan_model')->tambahKaryawan($data) > 0 ) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success');
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'error');
        }
        header('Location: ' . BASEURL . '/dashboard/karyawan');
        exit;
    }

    private function karyawanUpdate()
    {
        $fotoLama = $_POST['fotoLama'];
        
        if( $_FILES['foto']['error'] === 4 ) {
            $foto = $fotoLama;
        } else {
            $foto = $this->model('Karyawan_model')->upload();
        }

        $data = [
            'id_karyawan' => $_POST['id_karyawan'],
            'nama' => $_POST['nama'],
            'jabatan' => $_POST['jabatan'],
            'status' => $_POST['status'],
            'foto' => $foto
        ];

        if( $this->model('Karyawan_model')->ubahKaryawan($data) > 0 ) {
            Flasher::setFlash('berhasil', 'diubah', 'success');
        } else {
            Flasher::setFlash('gagal', 'diubah', 'error');
        }
        header('Location: ' . BASEURL . '/dashboard/karyawan');
        exit;
    }

    private function karyawanHapus($id)
    {
        if( $this->model('Karyawan_model')->hapusKaryawan($id) > 0 ) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'error');
        }
        header('Location: ' . BASEURL . '/dashboard/karyawan');
        exit;
    }

    // ==================== GALLERY ====================
    public function gallery($action = 'index', $id = null)
    {
        switch($action) {
            case 'tambah':
                $data['title'] = 'Tambah Gallery';
                $this->view('gallery/tambah', $data);
                break;
            case 'edit':
                $data['title'] = 'Edit Gallery';
                $data['gallery'] = $this->model('Gallery_model')->getGalleryById($id);
                $this->view('gallery/edit', $data);
                break;
            case 'simpan':
                $this->gallerySimpan();
                break;
            case 'update':
                $this->galleryUpdate();
                break;
            case 'hapus':
                $this->galleryHapus($id);
                break;
            default:
                $data['title'] = 'Kelola Gallery';
                $data['gallery'] = $this->model('Gallery_model')->getAllGallery();
                $this->view('gallery/index', $data);
        }
    }

    private function gallerySimpan()
    {
        $gambar = $this->model('Gallery_model')->upload();
        if( !$gambar ) {
            return false;
        }

        $data = [
            'judul' => $_POST['judul'],
            'deskripsi' => $_POST['deskripsi'],
            'status' => $_POST['status'],
            'gambar' => $gambar
        ];

        if( $this->model('Gallery_model')->tambahGallery($data) > 0 ) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success');
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'error');
        }
        header('Location: ' . BASEURL . '/dashboard/gallery');
        exit;
    }

    private function galleryUpdate()
    {
        $gambarLama = $_POST['gambarLama'];
        
        if( $_FILES['gambar']['error'] === 4 ) {
            $gambar = $gambarLama;
        } else {
            $gambar = $this->model('Gallery_model')->upload();
        }

        $data = [
            'id_gallery' => $_POST['id_gallery'],
            'judul' => $_POST['judul'],
            'deskripsi' => $_POST['deskripsi'],
            'status' => $_POST['status'],
            'gambar' => $gambar
        ];

        if( $this->model('Gallery_model')->ubahGallery($data) > 0 ) {
            Flasher::setFlash('berhasil', 'diubah', 'success');
        } else {
            Flasher::setFlash('gagal', 'diubah', 'error');
        }
        header('Location: ' . BASEURL . '/dashboard/gallery');
        exit;
    }

    private function galleryHapus($id)
    {
        if( $this->model('Gallery_model')->hapusGallery($id) > 0 ) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'error');
        }
        header('Location: ' . BASEURL . '/dashboard/gallery');
        exit;
    }

    // ==================== ARTIKEL ====================
    public function artikel($action = 'index', $id = null)
    {
        switch($action) {
            case 'tambah':
                $data['title'] = 'Tambah Artikel';
                $this->view('artikel/tambah', $data);
                break;
            case 'edit':
                $data['title'] = 'Edit Artikel';
                $data['artikel'] = $this->model('Artikel_model')->getArtikelById($id);
                $this->view('artikel/edit', $data);
                break;
            case 'simpan':
                $this->artikelSimpan();
                break;
            case 'update':
                $this->artikelUpdate();
                break;
            case 'hapus':
                $this->artikelHapus($id);
                break;
            default:
                $data['title'] = 'Kelola Artikel';
                $data['artikel'] = $this->model('Artikel_model')->getAllArtikel();
                $this->view('artikel/index', $data);
        }
    }

    private function artikelSimpan()
    {
        $gambar = $this->model('Artikel_model')->upload();
        if( $gambar === false ) {
            return false;
        }

        // Generate slug dari judul
        $slug = $this->model('Artikel_model')->generateSlug($_POST['judul']);

        $data = [
            'judul' => $_POST['judul'],
            'slug' => $slug,
            'konten' => $_POST['konten'],
            'gambar' => $gambar,
            'kategori' => $_POST['kategori'],
            'status' => $_POST['status'],
            'tanggal' => $_POST['tanggal'] ?? date('Y-m-d')
        ];

        if( $this->model('Artikel_model')->tambahArtikel($data) > 0 ) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success');
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'error');
        }
        header('Location: ' . BASEURL . '/dashboard/artikel');
        exit;
    }

    private function artikelUpdate()
    {
        $gambarLama = $_POST['gambarLama'];
        
        if( $_FILES['gambar']['error'] === 4 ) {
            $gambar = $gambarLama;
        } else {
            $gambar = $this->model('Artikel_model')->upload();
            if( $gambar === false ) {
                return false;
            }
        }

        // Generate slug baru jika judul berubah
        $artikelLama = $this->model('Artikel_model')->getArtikelById($_POST['id_artikel']);
        if ($artikelLama['judul'] !== $_POST['judul']) {
            $slug = $this->model('Artikel_model')->generateSlug($_POST['judul']);
        } else {
            $slug = $artikelLama['slug'];
        }

        $data = [
            'id_artikel' => $_POST['id_artikel'],
            'judul' => $_POST['judul'],
            'slug' => $slug,
            'konten' => $_POST['konten'],
            'gambar' => $gambar,
            'kategori' => $_POST['kategori'],
            'status' => $_POST['status'],
            'tanggal' => $_POST['tanggal'] ?? date('Y-m-d')
        ];

        if( $this->model('Artikel_model')->ubahArtikel($data) > 0 ) {
            Flasher::setFlash('berhasil', 'diubah', 'success');
        } else {
            Flasher::setFlash('gagal', 'diubah', 'error');
        }
        header('Location: ' . BASEURL . '/dashboard/artikel');
        exit;
    }

    private function artikelHapus($id)
    {
        if( $this->model('Artikel_model')->hapusArtikel($id) > 0 ) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'error');
        }
        header('Location: ' . BASEURL . '/dashboard/artikel');
        exit;
    }

    // ==================== PENGATURAN ====================
    public function pengaturan($action = 'index')
    {
        switch($action) {
            case 'update':
                $this->pengaturanUpdate();
                break;
            default:
                $data['title'] = 'Pengaturan Profil';
                $data['pengaturan'] = $this->model('Pengaturan_model')->getPengaturanForProfile();
                $this->view('pengaturan/index', $data);
        }
    }

    private function pengaturanUpdate()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'sejarah' => $_POST['sejarah'],
                'visi' => $_POST['visi'],
                'misi' => $_POST['misi'],
                'jam_senin_jumat' => $_POST['jam_senin_jumat'],
                'jam_sabtu' => $_POST['jam_sabtu'],
                'jam_minggu' => $_POST['jam_minggu'],
                'alamat' => $_POST['alamat'],
                'telepon' => $_POST['telepon'],
                'email' => $_POST['email'],
                'whatsapp' => $_POST['whatsapp'],
                'whatsapp_display' => $_POST['whatsapp_display']
            ];

            // Tambahkan pakasir config jika diisi
            if (!empty($_POST['pakasir_project'])) {
                $data['pakasir_project'] = $_POST['pakasir_project'];
            }
            if (!empty($_POST['pakasir_api_key'])) {
                $data['pakasir_api_key'] = $_POST['pakasir_api_key'];
            }

            if($this->model('Pengaturan_model')->updateMultiplePengaturan($data) > 0) {
                Flasher::setFlash('Pengaturan', 'berhasil disimpan', 'success');
            } else {
                Flasher::setFlash('Tidak ada perubahan', 'yang disimpan', 'info');
            }
            header('Location: ' . BASEURL . '/dashboard/pengaturan');
            exit;
        }
    }

    // ==================== LAPORAN ====================
    public function laporan($periode = 'harian', $param1 = null, $param2 = null)
    {
        $laporanModel = $this->model('Laporan_model');
        
        try {
            switch($periode) {
                case 'harian':
                    // Cek parameter GET dari form filter
                    $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : ($param1 ?: date('Y-m-d'));
                    
                    // Validasi format tanggal
                    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
                        $tanggal = date('Y-m-d');
                    }
                    
                    $data['title'] = 'Laporan Harian';
                    $data['periode'] = 'harian';
                    $data['tanggal'] = $tanggal;
                    $data['laporan'] = $laporanModel->getLaporanHarian($tanggal);
                    $data['detail'] = $laporanModel->getDetailHarian($tanggal);
                    $data['menu_terlaris'] = $laporanModel->getMenuTerlaris('harian', $tanggal);
                    $data['metode_bayar'] = $laporanModel->getMetodePembayaran('harian', $tanggal);
                    break;
                    
                case 'mingguan':
                    // Cek parameter GET dari form filter
                    $minggu = isset($_GET['minggu']) ? (int)$_GET['minggu'] : ($param1 ? (int)$param1 : (int)date('W'));
                    $tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : ($param2 ? (int)$param2 : (int)date('Y'));
                    
                    // Validasi minggu dan tahun
                    if ($minggu < 1 || $minggu > 53) $minggu = (int)date('W');
                    if ($tahun < 2020 || $tahun > 2099) $tahun = (int)date('Y');
                    
                    $data['title'] = 'Laporan Mingguan';
                    $data['periode'] = 'mingguan';
                    $data['minggu'] = $minggu;
                    $data['tahun'] = $tahun;
                    $data['periode_text'] = $laporanModel->getTanggalMinggu($minggu, $tahun);
                    $data['laporan'] = $laporanModel->getLaporanMingguan($minggu, $tahun);
                    $data['detail'] = $laporanModel->getDetailMingguan($minggu, $tahun);
                    $data['menu_terlaris'] = $laporanModel->getMenuTerlaris('mingguan', null, $minggu, null, $tahun);
                    $data['metode_bayar'] = $laporanModel->getMetodePembayaran('mingguan', null, $minggu, null, $tahun);
                    break;
                    
                case 'bulanan':
                    // Cek parameter GET dari form filter
                    $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : ($param1 ?: date('m'));
                    $tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : ($param2 ? (int)$param2 : (int)date('Y'));
                    
                    // Validasi bulan dan tahun
                    if (!preg_match('/^(0[1-9]|1[0-2])$/', $bulan)) $bulan = date('m');
                    if ($tahun < 2020 || $tahun > 2099) $tahun = (int)date('Y');
                    
                    $data['title'] = 'Laporan Bulanan';
                    $data['periode'] = 'bulanan';
                    $data['bulan'] = $bulan;
                    $data['tahun'] = $tahun;
                    $data['nama_bulan'] = $laporanModel->getNamaBulan($bulan);
                    $data['laporan'] = $laporanModel->getLaporanBulanan($bulan, $tahun);
                    $data['detail'] = $laporanModel->getDetailBulanan($bulan, $tahun);
                    $data['menu_terlaris'] = $laporanModel->getMenuTerlaris('bulanan', null, null, $bulan, $tahun);
                    $data['metode_bayar'] = $laporanModel->getMetodePembayaran('bulanan', null, null, $bulan, $tahun);
                    break;
                    
                default:
                    header('Location: ' . BASEURL . '/dashboard/laporan/harian');
                    exit;
            }
        } catch (Exception $e) {
            // Jika ada error, set data kosong dengan pesan error
            $data['title'] = 'Laporan Keuangan - Error';
            $data['periode'] = $periode;
            $data['error'] = $e->getMessage();
            $data['laporan'] = [
                'total_pesanan' => 0,
                'total_pendapatan' => 0,
                'rata_rata_pesanan' => 0,
                'pesanan_selesai' => 0,
                'pesanan_diproses' => 0
            ];
            $data['detail'] = [];
            $data['menu_terlaris'] = [];
            $data['metode_bayar'] = [];
        }
        
        $this->view('laporan/index', $data);
    }

    // Debug method untuk troubleshooting laporan
    public function debug_laporan()
    {
        $laporanModel = $this->model('Laporan_model');
        $debug = $laporanModel->debugInfo();
        
        echo "<h2>Debug Laporan Keuangan</h2>";
        echo "<pre>";
        print_r($debug);
        echo "</pre>";
        
        // Test query sederhana
        echo "<h3>Test Query Harian (Hari ini)</h3>";
        $today = date('Y-m-d');
        $result = $laporanModel->getLaporanHarian($today);
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        
        echo "<h3>Test Detail Harian (Hari ini)</h3>";
        $detail = $laporanModel->getDetailHarian($today);
        echo "<pre>";
        print_r($detail);
        echo "</pre>";
    }

    // ==================== EXPORT LAPORAN ====================
    public function export_laporan($format = 'excel', $periode = 'harian')
    {
        require_once 'app/services/ExportService.php';
        $exportService = new ExportService();
        $laporanModel = $this->model('Laporan_model');
        
        // Ambil parameter dari GET
        $data = [];
        
        try {
            switch($periode) {
                case 'harian':
                    $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');
                    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
                        $tanggal = date('Y-m-d');
                    }
                    
                    $data['title'] = 'Laporan Harian';
                    $data['periode'] = 'harian';
                    $data['periode_text'] = date('d F Y', strtotime($tanggal));
                    $data['laporan'] = $laporanModel->getLaporanHarian($tanggal);
                    $data['detail'] = $laporanModel->getDetailHarian($tanggal);
                    $data['menu_terlaris'] = $laporanModel->getMenuTerlaris('harian', $tanggal);
                    $data['metode_bayar'] = $laporanModel->getMetodePembayaran('harian', $tanggal);
                    $filename = 'laporan_harian_' . $tanggal;
                    break;
                    
                case 'mingguan':
                    $minggu = isset($_GET['minggu']) ? (int)$_GET['minggu'] : (int)date('W');
                    $tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : (int)date('Y');
                    if ($minggu < 1 || $minggu > 53) $minggu = (int)date('W');
                    if ($tahun < 2020 || $tahun > 2099) $tahun = (int)date('Y');
                    
                    $data['title'] = 'Laporan Mingguan';
                    $data['periode'] = 'mingguan';
                    $data['periode_text'] = 'Minggu ke-' . $minggu . ' Tahun ' . $tahun . ' (' . $laporanModel->getTanggalMinggu($minggu, $tahun) . ')';
                    $data['laporan'] = $laporanModel->getLaporanMingguan($minggu, $tahun);
                    $data['detail'] = $laporanModel->getDetailMingguan($minggu, $tahun);
                    $data['menu_terlaris'] = $laporanModel->getMenuTerlaris('mingguan', null, $minggu, null, $tahun);
                    $data['metode_bayar'] = $laporanModel->getMetodePembayaran('mingguan', null, $minggu, null, $tahun);
                    $filename = 'laporan_mingguan_w' . $minggu . '_' . $tahun;
                    break;
                    
                case 'bulanan':
                    $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
                    $tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : (int)date('Y');
                    if (!preg_match('/^(0[1-9]|1[0-2])$/', $bulan)) $bulan = date('m');
                    if ($tahun < 2020 || $tahun > 2099) $tahun = (int)date('Y');
                    
                    $data['title'] = 'Laporan Bulanan';
                    $data['periode'] = 'bulanan';
                    $data['periode_text'] = $laporanModel->getNamaBulan($bulan) . ' ' . $tahun;
                    $data['laporan'] = $laporanModel->getLaporanBulanan($bulan, $tahun);
                    $data['detail'] = $laporanModel->getDetailBulanan($bulan, $tahun);
                    $data['menu_terlaris'] = $laporanModel->getMenuTerlaris('bulanan', null, null, $bulan, $tahun);
                    $data['metode_bayar'] = $laporanModel->getMetodePembayaran('bulanan', null, null, $bulan, $tahun);
                    $filename = 'laporan_bulanan_' . $bulan . '_' . $tahun;
                    break;
                    
                default:
                    header('Location: ' . BASEURL . '/dashboard/laporan');
                    exit;
            }
            
            // Export berdasarkan format
            if ($format === 'pdf') {
                $exportService->exportPDF($data, $filename);
            } else {
                $exportService->exportExcel($data, $filename);
            }
            
        } catch (Exception $e) {
            Flasher::setFlash('Gagal export: ' . $e->getMessage(), '', 'error');
            header('Location: ' . BASEURL . '/dashboard/laporan/' . $periode);
            exit;
        }
    }

    // ==================== ORDER ====================
    public function order($action = 'index', $id = null)
    {
        switch($action) {
            case 'detail':
                $data['title'] = 'Detail Pesanan';
                $data['order'] = $this->model('Order_model')->getOrderById($id);
                $data['order_details'] = $this->model('Order_model')->getOrderDetails($id);
                $data['payment'] = $this->model('Payment_model')->getPaymentByOrderId($id);
                $this->view('order/detail', $data);
                break;
            case 'updateStatus':
                $this->orderUpdateStatus();
                break;
            case 'updatePayment':
                $this->orderUpdatePayment();
                break;
            case 'updateStatusBoth':
                $this->orderUpdateStatusBoth();
                break;
            case 'updateStatusBothDetail':
                $this->orderUpdateStatusBothDetail();
                break;
            default:
                $data['title'] = 'Daftar Pesanan';
                $data['orders'] = $this->model('Order_model')->getAllOrders();
                $this->view('order/index', $data);
        }
    }

    private function orderUpdateStatus()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_order = $_POST['id_order'];
            $status = $_POST['status'];
            
            if($this->model('Order_model')->updateOrderStatus($id_order, $status) > 0) {
                Flasher::setFlash('berhasil', 'diupdate', 'success');
            } else {
                Flasher::setFlash('gagal', 'diupdate', 'error');
            }
            header('Location: ' . BASEURL . '/dashboard/order/detail/' . $id_order);
            exit;
        }
    }

    private function orderUpdatePayment()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_payment = $_POST['id_payment'];
            $id_order = $_POST['id_order'];
            $status = $_POST['status_bayar'];
            
            if($this->model('Payment_model')->updatePaymentStatus($id_payment, $status) > 0) {
                Flasher::setFlash('berhasil', 'diupdate', 'success');
            } else {
                Flasher::setFlash('gagal', 'diupdate', 'error');
            }
            header('Location: ' . BASEURL . '/dashboard/order/detail/' . $id_order);
            exit;
        }
    }

    private function orderUpdateStatusBoth()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_order = $_POST['id_order'];
            $id_payment = $_POST['id_payment'];
            $status_order = $_POST['status_order'];
            $status_bayar = $_POST['status_bayar'];
            
            $orderUpdated = $this->model('Order_model')->updateOrderStatus($id_order, $status_order);
            
            $paymentUpdated = 0;
            if(!empty($id_payment)) {
                $paymentUpdated = $this->model('Payment_model')->updatePaymentStatus($id_payment, $status_bayar);
            }
            
            if($orderUpdated > 0 || $paymentUpdated > 0) {
                Flasher::setFlash('Status', 'berhasil diupdate', 'success');
            } else {
                Flasher::setFlash('Tidak ada perubahan', 'yang disimpan', 'info');
            }
            header('Location: ' . BASEURL . '/dashboard/order');
            exit;
        }
    }

    private function orderUpdateStatusBothDetail()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_order = $_POST['id_order'];
            $id_payment = $_POST['id_payment'];
            $status_order = $_POST['status_order'];
            $status_bayar = $_POST['status_bayar'];
            
            $orderUpdated = $this->model('Order_model')->updateOrderStatus($id_order, $status_order);
            
            $paymentUpdated = 0;
            if(!empty($id_payment)) {
                $paymentUpdated = $this->model('Payment_model')->updatePaymentStatus($id_payment, $status_bayar);
            }
            
            if($orderUpdated > 0 || $paymentUpdated > 0) {
                Flasher::setFlash('Status', 'berhasil diupdate', 'success');
            } else {
                Flasher::setFlash('Tidak ada perubahan', 'yang disimpan', 'info');
            }
            header('Location: ' . BASEURL . '/dashboard/order/detail/' . $id_order);
            exit;
        }
    }
}
