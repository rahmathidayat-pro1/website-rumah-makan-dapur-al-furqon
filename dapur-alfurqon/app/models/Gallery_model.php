<?php

class Gallery_model {
    private $table = 'gallery';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllGallery()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function getActiveGallery()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE status = "aktif" ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function getGalleryById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_gallery=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahGallery($data)
    {
        $query = "INSERT INTO gallery (judul, deskripsi, gambar, status)
                  VALUES (:judul, :deskripsi, :gambar, :status)";
        
        $this->db->query($query);
        $this->db->bind('judul', $data['judul']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('gambar', $data['gambar']);
        $this->db->bind('status', $data['status']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusGallery($id)
    {
        $this->db->query('DELETE FROM ' . $this->table . ' WHERE id_gallery = :id');
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahGallery($data)
    {
        $query = "UPDATE gallery SET
                    judul = :judul,
                    deskripsi = :deskripsi,
                    gambar = :gambar,
                    status = :status
                  WHERE id_gallery = :id_gallery";
        
        $this->db->query($query);
        $this->db->bind('judul', $data['judul']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('gambar', $data['gambar']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('id_gallery', $data['id_gallery']);

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
        $ekstensiFotoValid = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ekstensiFoto = explode('.', $namaFile);
        $ekstensiFoto = strtolower(end($ekstensiFoto));
        if( !in_array($ekstensiFoto, $ekstensiFotoValid) ) {
            echo "<script>
                    alert('Yang anda upload bukan gambar!');
                  </script>";
            return false;
        }

        // Cek jika ukurannya terlalu besar (max 5MB)
        if( $ukuranFile > 5000000 ) {
            echo "<script>
                    alert('Ukuran gambar terlalu besar! Maksimal 5MB');
                  </script>";
            return false;
        }

        // Lolos pengecekan, gambar siap diupload
        // Generate nama gambar baru
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiFoto;

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
