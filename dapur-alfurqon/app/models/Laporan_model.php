<?php

class Laporan_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Laporan Harian
    public function getLaporanHarian($tanggal = null)
    {
        if (!$tanggal) {
            $tanggal = date('Y-m-d');
        }

        $query = "SELECT 
                    COUNT(o.id_order) as total_pesanan,
                    COALESCE(SUM(o.total_harga), 0) as total_pendapatan,
                    COALESCE(AVG(o.total_harga), 0) as rata_rata_pesanan,
                    COUNT(CASE WHEN o.status_order = 'selesai' THEN 1 END) as pesanan_selesai,
                    COUNT(CASE WHEN o.status_order = 'diproses' THEN 1 END) as pesanan_diproses
                  FROM orders o 
                  WHERE DATE(o.tanggal_order) = :tanggal";

        $this->db->query($query);
        $this->db->bind('tanggal', $tanggal);
        $result = $this->db->single();
        
        // Pastikan semua nilai numerik
        if ($result) {
            $result['total_pesanan'] = (int)$result['total_pesanan'];
            $result['total_pendapatan'] = (int)$result['total_pendapatan'];
            $result['rata_rata_pesanan'] = (int)$result['rata_rata_pesanan'];
            $result['pesanan_selesai'] = (int)$result['pesanan_selesai'];
            $result['pesanan_diproses'] = (int)$result['pesanan_diproses'];
        }
        
        return $result;
    }

    public function getDetailHarian($tanggal = null)
    {
        if (!$tanggal) {
            $tanggal = date('Y-m-d');
        }

        // Cek apakah kolom nomor_pesanan ada
        $checkColumn = "SHOW COLUMNS FROM orders LIKE 'nomor_pesanan'";
        $this->db->query($checkColumn);
        $hasNomorPesanan = $this->db->single();

        if ($hasNomorPesanan) {
            $query = "SELECT 
                        o.nomor_pesanan,
                        o.nama_pelanggan,
                        o.total_harga,
                        o.status_order,
                        TIME(o.tanggal_order) as jam_order,
                        COALESCE(p.metode, 'tunai') as metode_bayar,
                        COALESCE(p.status_bayar, 'belum') as status_bayar
                      FROM orders o
                      LEFT JOIN payment p ON o.id_order = p.id_order
                      WHERE DATE(o.tanggal_order) = :tanggal
                      ORDER BY o.tanggal_order DESC";
        } else {
            $query = "SELECT 
                        CONCAT('ORD-', o.id_order) as nomor_pesanan,
                        o.nama_pelanggan,
                        o.total_harga,
                        o.status_order,
                        TIME(o.tanggal_order) as jam_order,
                        COALESCE(p.metode, 'tunai') as metode_bayar,
                        COALESCE(p.status_bayar, 'belum') as status_bayar
                      FROM orders o
                      LEFT JOIN payment p ON o.id_order = p.id_order
                      WHERE DATE(o.tanggal_order) = :tanggal
                      ORDER BY o.tanggal_order DESC";
        }

        $this->db->query($query);
        $this->db->bind('tanggal', $tanggal);
        return $this->db->resultSet();
    }

    // Laporan Mingguan
    public function getLaporanMingguan($minggu = null, $tahun = null)
    {
        if (!$minggu) {
            $minggu = date('W');
        }
        if (!$tahun) {
            $tahun = date('Y');
        }

        $query = "SELECT 
                    COUNT(o.id_order) as total_pesanan,
                    COALESCE(SUM(o.total_harga), 0) as total_pendapatan,
                    COALESCE(AVG(o.total_harga), 0) as rata_rata_pesanan,
                    COUNT(CASE WHEN o.status_order = 'selesai' THEN 1 END) as pesanan_selesai,
                    COUNT(CASE WHEN o.status_order = 'diproses' THEN 1 END) as pesanan_diproses
                  FROM orders o 
                  WHERE WEEK(o.tanggal_order, 1) = :minggu 
                  AND YEAR(o.tanggal_order) = :tahun";

        $this->db->query($query);
        $this->db->bind('minggu', $minggu);
        $this->db->bind('tahun', $tahun);
        return $this->db->single();
    }

    public function getDetailMingguan($minggu = null, $tahun = null)
    {
        if (!$minggu) {
            $minggu = date('W');
        }
        if (!$tahun) {
            $tahun = date('Y');
        }

        $query = "SELECT 
                    DATE(o.tanggal_order) as tanggal,
                    COUNT(o.id_order) as total_pesanan,
                    COALESCE(SUM(o.total_harga), 0) as total_pendapatan,
                    COUNT(CASE WHEN o.status_order = 'selesai' THEN 1 END) as pesanan_selesai
                  FROM orders o 
                  WHERE WEEK(o.tanggal_order, 1) = :minggu 
                  AND YEAR(o.tanggal_order) = :tahun
                  GROUP BY DATE(o.tanggal_order)
                  ORDER BY DATE(o.tanggal_order)";

        $this->db->query($query);
        $this->db->bind('minggu', $minggu);
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }

    // Laporan Bulanan
    public function getLaporanBulanan($bulan = null, $tahun = null)
    {
        if (!$bulan) {
            $bulan = date('m');
        }
        if (!$tahun) {
            $tahun = date('Y');
        }

        $query = "SELECT 
                    COUNT(o.id_order) as total_pesanan,
                    COALESCE(SUM(o.total_harga), 0) as total_pendapatan,
                    COALESCE(AVG(o.total_harga), 0) as rata_rata_pesanan,
                    COUNT(CASE WHEN o.status_order = 'selesai' THEN 1 END) as pesanan_selesai,
                    COUNT(CASE WHEN o.status_order = 'diproses' THEN 1 END) as pesanan_diproses
                  FROM orders o 
                  WHERE MONTH(o.tanggal_order) = :bulan 
                  AND YEAR(o.tanggal_order) = :tahun";

        $this->db->query($query);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        return $this->db->single();
    }

    public function getDetailBulanan($bulan = null, $tahun = null)
    {
        if (!$bulan) {
            $bulan = date('m');
        }
        if (!$tahun) {
            $tahun = date('Y');
        }

        $query = "SELECT 
                    DATE(o.tanggal_order) as tanggal,
                    COUNT(o.id_order) as total_pesanan,
                    COALESCE(SUM(o.total_harga), 0) as total_pendapatan,
                    COUNT(CASE WHEN o.status_order = 'selesai' THEN 1 END) as pesanan_selesai
                  FROM orders o 
                  WHERE MONTH(o.tanggal_order) = :bulan 
                  AND YEAR(o.tanggal_order) = :tahun
                  GROUP BY DATE(o.tanggal_order)
                  ORDER BY DATE(o.tanggal_order)";

        $this->db->query($query);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }

    // Menu Terlaris
    public function getMenuTerlaris($periode = 'harian', $tanggal = null, $minggu = null, $bulan = null, $tahun = null)
    {
        $whereClause = '';
        $params = [];

        switch ($periode) {
            case 'harian':
                $tanggal = $tanggal ?: date('Y-m-d');
                $whereClause = 'WHERE DATE(o.tanggal_order) = :tanggal';
                $params['tanggal'] = $tanggal;
                break;
            case 'mingguan':
                $minggu = $minggu ?: date('W');
                $tahun = $tahun ?: date('Y');
                $whereClause = 'WHERE WEEK(o.tanggal_order, 1) = :minggu AND YEAR(o.tanggal_order) = :tahun';
                $params['minggu'] = $minggu;
                $params['tahun'] = $tahun;
                break;
            case 'bulanan':
                $bulan = $bulan ?: date('m');
                $tahun = $tahun ?: date('Y');
                $whereClause = 'WHERE MONTH(o.tanggal_order) = :bulan AND YEAR(o.tanggal_order) = :tahun';
                $params['bulan'] = $bulan;
                $params['tahun'] = $tahun;
                break;
        }

        $query = "SELECT 
                    m.nama_menu,
                    m.harga,
                    SUM(od.jumlah) as total_terjual,
                    SUM(od.subtotal) as total_pendapatan
                  FROM order_detail od
                  JOIN menu m ON od.id_menu = m.id_menu
                  JOIN orders o ON od.id_order = o.id_order
                  $whereClause
                  GROUP BY od.id_menu, m.nama_menu, m.harga
                  ORDER BY total_terjual DESC
                  LIMIT 10";

        $this->db->query($query);
        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }
        return $this->db->resultSet();
    }

    // Metode Pembayaran
    public function getMetodePembayaran($periode = 'harian', $tanggal = null, $minggu = null, $bulan = null, $tahun = null)
    {
        $whereClause = '';
        $params = [];

        switch ($periode) {
            case 'harian':
                $tanggal = $tanggal ?: date('Y-m-d');
                $whereClause = 'WHERE DATE(o.tanggal_order) = :tanggal';
                $params['tanggal'] = $tanggal;
                break;
            case 'mingguan':
                $minggu = $minggu ?: date('W');
                $tahun = $tahun ?: date('Y');
                $whereClause = 'WHERE WEEK(o.tanggal_order, 1) = :minggu AND YEAR(o.tanggal_order) = :tahun';
                $params['minggu'] = $minggu;
                $params['tahun'] = $tahun;
                break;
            case 'bulanan':
                $bulan = $bulan ?: date('m');
                $tahun = $tahun ?: date('Y');
                $whereClause = 'WHERE MONTH(o.tanggal_order) = :bulan AND YEAR(o.tanggal_order) = :tahun';
                $params['bulan'] = $bulan;
                $params['tahun'] = $tahun;
                break;
        }

        $query = "SELECT 
                    p.metode,
                    COUNT(p.id_payment) as jumlah_transaksi,
                    COALESCE(SUM(o.total_harga), 0) as total_nilai
                  FROM payment p
                  JOIN orders o ON p.id_order = o.id_order
                  $whereClause
                  GROUP BY p.metode
                  ORDER BY jumlah_transaksi DESC";

        $this->db->query($query);
        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }
        return $this->db->resultSet();
    }

    // Helper functions
    public function getNamaBulan($bulan)
    {
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $namaBulan[(int)$bulan] ?? '';
    }

    public function getTanggalMinggu($minggu, $tahun)
    {
        try {
            $dto = new DateTime();
            $dto->setISODate($tahun, $minggu);
            $start = $dto->format('d M Y');
            $dto->modify('+6 days');
            $end = $dto->format('d M Y');
            return "$start - $end";
        } catch (Exception $e) {
            return "Minggu $minggu, $tahun";
        }
    }

    // Debug method untuk mengecek koneksi dan data
    public function debugInfo()
    {
        $info = [];
        
        // Cek koneksi database
        try {
            $this->db->query("SELECT 1");
            $info['database_connection'] = 'OK';
        } catch (Exception $e) {
            $info['database_connection'] = 'ERROR: ' . $e->getMessage();
        }
        
        // Cek tabel orders
        try {
            $this->db->query("SELECT COUNT(*) as total FROM orders");
            $result = $this->db->single();
            $info['orders_table'] = 'OK - Total records: ' . $result['total'];
        } catch (Exception $e) {
            $info['orders_table'] = 'ERROR: ' . $e->getMessage();
        }
        
        // Cek tabel payment
        try {
            $this->db->query("SELECT COUNT(*) as total FROM payment");
            $result = $this->db->single();
            $info['payment_table'] = 'OK - Total records: ' . $result['total'];
        } catch (Exception $e) {
            $info['payment_table'] = 'ERROR: ' . $e->getMessage();
        }
        
        // Cek struktur kolom orders
        try {
            $this->db->query("SHOW COLUMNS FROM orders");
            $columns = $this->db->resultSet();
            $info['orders_columns'] = array_column($columns, 'Field');
        } catch (Exception $e) {
            $info['orders_columns'] = 'ERROR: ' . $e->getMessage();
        }
        
        return $info;
    }
}