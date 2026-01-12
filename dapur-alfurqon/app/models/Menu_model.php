<?php

class Menu_model {
    private $table = 'menu';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllMenu()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }

    public function getMenuById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_menu=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function cariMenu($keyword)
    {
        $keyword = "%$keyword%";
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE nama_menu LIKE :keyword OR deskripsi LIKE :keyword');
        $this->db->bind('keyword', $keyword);
        return $this->db->resultSet();
    }

    public function tambahMenu($data)
    {
        $query = "INSERT INTO menu (nama_menu, kategori, harga, deskripsi, gambar, status)
                  VALUES (:nama_menu, :kategori, :harga, :deskripsi, :gambar, :status)";
        
        $this->db->query($query);
        $this->db->bind('nama_menu', $data['nama_menu']);
        $this->db->bind('kategori', $data['kategori']);
        $this->db->bind('harga', $data['harga']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('gambar', $data['gambar']);
        $this->db->bind('status', $data['status']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusMenu($id)
    {
        $this->db->query('DELETE FROM ' . $this->table . ' WHERE id_menu = :id');
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahMenu($data)
    {
        $query = "UPDATE menu SET
                    nama_menu = :nama_menu,
                    kategori = :kategori,
                    harga = :harga,
                    deskripsi = :deskripsi,
                    gambar = :gambar,
                    status = :status
                  WHERE id_menu = :id_menu";
        
        $this->db->query($query);
        $this->db->bind('nama_menu', $data['nama_menu']);
        $this->db->bind('kategori', $data['kategori']);
        $this->db->bind('harga', $data['harga']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('gambar', $data['gambar']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('id_menu', $data['id_menu']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getMenuTerlaris($limit = 5)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY jumlah_terjual DESC LIMIT :limit');
        $this->db->bind('limit', $limit);
        return $this->db->resultSet();
    }

    public function updateJumlahTerjual($id_menu, $jumlah)
    {
        $this->db->query('UPDATE menu SET jumlah_terjual = jumlah_terjual + :jumlah WHERE id_menu = :id_menu');
        $this->db->bind('jumlah', $jumlah);
        $this->db->bind('id_menu', $id_menu);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function upload()
    {
        $namaFile = $_FILES['gambar']['name'];
        $ukuranFile = $_FILES['gambar']['size'];
        $error = $_FILES['gambar']['error'];
        $tmpName = $_FILES['gambar']['tmp_name'];

        // Cek apakah tidak ada gambar yang diupload
        if( $error === 4 ) {
            return 'default.jpg';
        }

        // Cek apakah yang diupload adalah gambar
        $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
            echo "<script>
                    alert('yang anda upload bukan gambar!');
                  </script>";
            return false;
        }

        // Cek jika ukurannya terlalu besar (max 2MB)
        if( $ukuranFile > 2000000 ) {
            echo "<script>
                    alert('ukuran gambar terlalu besar!');
                  </script>";
            return false;
        }

        // Lolos pengecekan, gambar siap diupload
        // Generate nama gambar baru
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;

        // Gunakan absolute path untuk kompatibilitas macOS/Linux
        $uploadPath = dirname(__DIR__, 2) . '/public/img/' . $namaFileBaru;
        
        // Pastikan folder exists
        $uploadDir = dirname($uploadPath);
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        move_uploaded_file($tmpName, $uploadPath);

        return $namaFileBaru;
    }
}
