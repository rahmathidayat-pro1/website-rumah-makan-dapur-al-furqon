<?php

class Payment_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function createPayment($id_order, $metode, $qrisData = null)
    {
        // Check if QRIS columns exist
        $this->db->query("SHOW COLUMNS FROM payment LIKE 'qris_string'");
        $hasQrisColumns = $this->db->single();
        
        if ($hasQrisColumns && $qrisData) {
            // Use new schema with QRIS columns
            $query = "INSERT INTO payment (id_order, metode, status_bayar, qris_string, qris_expired, pakasir_fee, pakasir_total)
                      VALUES (:id_order, :metode, 'belum', :qris_string, :qris_expired, :pakasir_fee, :pakasir_total)";
            
            $this->db->query($query);
            $this->db->bind('id_order', $id_order);
            $this->db->bind('metode', $metode);
            $this->db->bind('qris_string', $qrisData['qris_string'] ?? null);
            $this->db->bind('qris_expired', $qrisData['qris_expired'] ?? null);
            $this->db->bind('pakasir_fee', $qrisData['pakasir_fee'] ?? null);
            $this->db->bind('pakasir_total', $qrisData['pakasir_total'] ?? null);
        } else {
            // Use old schema (backward compatibility)
            $query = "INSERT INTO payment (id_order, metode, status_bayar)
                      VALUES (:id_order, :metode, 'belum')";
            
            $this->db->query($query);
            $this->db->bind('id_order', $id_order);
            $this->db->bind('metode', $metode);
        }
        
        $this->db->execute();
        return $this->db->getLastInsertId();
    }

    public function getPaymentByOrderId($id_order)
    {
        $this->db->query('SELECT * FROM payment WHERE id_order = :id_order');
        $this->db->bind('id_order', $id_order);
        return $this->db->single();
    }

    public function getPaymentByPakasirOrderId($pakasir_order_id)
    {
        $this->db->query('SELECT p.*, o.nomor_pesanan, o.total_harga 
                         FROM payment p 
                         JOIN orders o ON p.id_order = o.id_order 
                         WHERE o.nomor_pesanan = :pakasir_order_id');
        $this->db->bind('pakasir_order_id', $pakasir_order_id);
        return $this->db->single();
    }

    public function updatePaymentStatus($id_payment, $status)
    {
        $query = "UPDATE payment SET status_bayar = :status";
        
        if($status == 'lunas') {
            $query .= ", waktu_bayar = NOW()";
        }
        
        $query .= " WHERE id_payment = :id_payment";
        
        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('id_payment', $id_payment);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function updatePaymentStatusByOrderId($id_order, $status)
    {
        $query = "UPDATE payment SET status_bayar = :status";
        
        if($status == 'lunas') {
            $query .= ", waktu_bayar = NOW()";
        }
        
        $query .= " WHERE id_order = :id_order";
        
        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('id_order', $id_order);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function isQRISExpired($id_payment)
    {
        // Check if QRIS columns exist
        $this->db->query("SHOW COLUMNS FROM payment LIKE 'qris_expired'");
        $hasQrisColumns = $this->db->single();
        
        if (!$hasQrisColumns) {
            return true; // Consider expired if no QRIS support
        }
        
        $this->db->query('SELECT qris_expired FROM payment WHERE id_payment = :id_payment');
        $this->db->bind('id_payment', $id_payment);
        $payment = $this->db->single();
        
        if (!$payment || !$payment['qris_expired']) {
            return true;
        }
        
        try {
            // Assume stored datetime is in local timezone (Asia/Jakarta)
            $localTimezone = new DateTimeZone('Asia/Jakarta');
            $expired = new DateTime($payment['qris_expired'], $localTimezone);
            $now = new DateTime('now', $localTimezone);
            
            // Debug logging
            error_log("QRIS Expiry Check - Expired: " . $expired->format('Y-m-d H:i:s T') . ", Now: " . $now->format('Y-m-d H:i:s T'));
            
            return $now > $expired;
        } catch (Exception $e) {
            error_log("isQRISExpired error: " . $e->getMessage());
            return true;
        }
    }
}
