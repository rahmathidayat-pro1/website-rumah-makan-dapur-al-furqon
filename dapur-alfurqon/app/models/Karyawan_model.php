<?php

class Karyawan_model {
    private $table = 'karyawan';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllKaryawan()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }

    public function getActiveKaryawan()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE status = "aktif"');
        return $this->db->resultSet();
    }

    public function getKaryawanById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_karyawan=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahKaryawan($data)
    {
        $query = "INSERT INTO karyawan (nama, jabatan, foto, status)
                  VALUES (:nama, :jabatan, :foto, :status)";
        
        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('jabatan', $data['jabatan']);
        $this->db->bind('foto', $data['foto']);
        $this->db->bind('status', $data['status']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusKaryawan($id)
    {
        $this->db->query('DELETE FROM ' . $this->table . ' WHERE id_karyawan = :id');
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahKaryawan($data)
    {
        $query = "UPDATE karyawan SET
                    nama = :nama,
                    jabatan = :jabatan,
                    foto = :foto,
                    status = :status
                  WHERE id_karyawan = :id_karyawan";
        
        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('jabatan', $data['jabatan']);
        $this->db->bind('foto', $data['foto']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('id_karyawan', $data['id_karyawan']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function upload()
    {
        $namaFile = $_FILES['foto']['name'];
        $ukuranFile = $_FILES['foto']['size'];
        $error = $_FILES['foto']['error'];
        $tmpName = $_FILES['foto']['tmp_name'];

        // Cek apakah tidak ada foto yang diupload
        if( $error === 4 ) {
            return 'default.jpg';
        }

        // Cek apakah yang diupload adalah gambar
        $ekstensiFotoValid = ['jpg', 'jpeg', 'png'];
        $ekstensiFoto = explode('.', $namaFile);
        $ekstensiFoto = strtolower(end($ekstensiFoto));
        if( !in_array($ekstensiFoto, $ekstensiFotoValid) ) {
            echo "<script>
                    alert('yang anda upload bukan gambar!');
                  </script>";
            return false;
        }

        // Cek jika ukurannya terlalu besar (max 2MB)
        if( $ukuranFile > 2000000 ) {
            echo "<script>
                    alert('ukuran foto terlalu besar!');
                  </script>";
            return false;
        }

        // Lolos pengecekan, foto siap diupload
        // Generate nama foto baru
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
