<?php

class Order_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function createOrder($data)
    {
        // Generate nomor pesanan
        $nomor_pesanan = $this->generateNomorPesanan();
        
        $query = "INSERT INTO orders (nomor_pesanan, nama_pelanggan, no_telepon, catatan, total_harga, status_order)
                  VALUES (:nomor_pesanan, :nama_pelanggan, :no_telepon, :catatan, :total_harga, 'diproses')";
        
        $this->db->query($query);
        $this->db->bind('nomor_pesanan', $nomor_pesanan);
        $this->db->bind('nama_pelanggan', $data['nama_pelanggan']);
        $this->db->bind('no_telepon', $data['no_telepon']);
        $this->db->bind('catatan', $data['catatan']);
        $this->db->bind('total_harga', $data['total_harga']);
        $this->db->execute();
        
        // Get last inserted ID
        return $this->db->getLastInsertId();
    }

    public function generateNomorPesanan()
    {
        // Format: YYYYMMDD-XXX (contoh: 20241219-001)
        $today = date('Ymd');
        
        // Cari nomor pesanan terakhir hari ini
        $query = "SELECT nomor_pesanan FROM orders 
                  WHERE DATE(tanggal_order) = CURDATE() 
                  ORDER BY nomor_pesanan DESC 
                  LIMIT 1";
        
        $this->db->query($query);
        $lastOrder = $this->db->single();
        
        if ($lastOrder) {
            // Ambil nomor urut dari nomor pesanan terakhir
            $lastNumber = (int) substr($lastOrder['nomor_pesanan'], -3);
            $nextNumber = $lastNumber + 1;
        } else {
            // Jika belum ada pesanan hari ini, mulai dari 1
            $nextNumber = 1;
        }
        
        // Format nomor dengan 3 digit (001, 002, dst)
        return $today . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function getOrderByNomor($nomor_pesanan)
    {
        $this->db->query('SELECT * FROM orders WHERE nomor_pesanan = :nomor_pesanan');
        $this->db->bind('nomor_pesanan', $nomor_pesanan);
        return $this->db->single();
    }

    public function addOrderDetail($id_order, $id_menu, $jumlah, $subtotal)
    {
        $query = "INSERT INTO order_detail (id_order, id_menu, jumlah, subtotal)
                  VALUES (:id_order, :id_menu, :jumlah, :subtotal)";
        
        $this->db->query($query);
        $this->db->bind('id_order', $id_order);
        $this->db->bind('id_menu', $id_menu);
        $this->db->bind('jumlah', $jumlah);
        $this->db->bind('subtotal', $subtotal);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function getAllOrders()
    {
        $query = "SELECT o.*, p.id_payment, p.status_bayar, p.metode 
                  FROM orders o 
                  LEFT JOIN payment p ON o.id_order = p.id_order 
                  ORDER BY o.tanggal_order DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getOrderById($id)
    {
        $this->db->query('SELECT * FROM orders WHERE id_order = :id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function getOrderDetails($id_order)
    {
        $query = "SELECT od.*, m.nama_menu, m.gambar 
                  FROM order_detail od
                  JOIN menu m ON od.id_menu = m.id_menu
                  WHERE od.id_order = :id_order";
        
        $this->db->query($query);
        $this->db->bind('id_order', $id_order);
        return $this->db->resultSet();
    }

    public function updateOrderStatus($id_order, $status)
    {
        $query = "UPDATE orders SET status_order = :status WHERE id_order = :id_order";
        
        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('id_order', $id_order);
        $this->db->execute();
        
        return $this->db->rowCount();
    }
}
