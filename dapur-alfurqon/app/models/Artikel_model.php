<?php

class Artikel_model {
    private $table = 'artikel';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllArtikel()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function getArtikelById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_artikel=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function getArtikelBySlug($slug)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE slug=:slug');
        $this->db->bind('slug', $slug);
        return $this->db->single();
    }

    public function cariArtikel($keyword)
    {
        $keyword = "%$keyword%";
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE judul LIKE :keyword OR konten LIKE :keyword ORDER BY created_at DESC');
        $this->db->bind('keyword', $keyword);
        return $this->db->resultSet();
    }

    public function tambahArtikel($data)
    {
        $query = "INSERT INTO artikel (judul, slug, konten, gambar, kategori, status, tanggal)
                  VALUES (:judul, :slug, :konten, :gambar, :kategori, :status, :tanggal)";
        
        $this->db->query($query);
        $this->db->bind('judul', $data['judul']);
        $this->db->bind('slug', $data['slug']);
        $this->db->bind('konten', $data['konten']);
        $this->db->bind('gambar', $data['gambar']);
        $this->db->bind('kategori', $data['kategori']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('tanggal', $data['tanggal'] ?? date('Y-m-d'));

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusArtikel($id)
    {
        $this->db->query('DELETE FROM ' . $this->table . ' WHERE id_artikel = :id');
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahArtikel($data)
    {
        $query = "UPDATE artikel SET
                    judul = :judul,
                    slug = :slug,
                    konten = :konten,
                    gambar = :gambar,
                    kategori = :kategori,
                    status = :status,
                    tanggal = :tanggal
                  WHERE id_artikel = :id_artikel";
        
        $this->db->query($query);
        $this->db->bind('judul', $data['judul']);
        $this->db->bind('slug', $data['slug']);
        $this->db->bind('konten', $data['konten']);
        $this->db->bind('gambar', $data['gambar']);
        $this->db->bind('kategori', $data['kategori']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('tanggal', $data['tanggal'] ?? date('Y-m-d'));
        $this->db->bind('id_artikel', $data['id_artikel']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getArtikelPublished($limit = null)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE status = "published" ORDER BY created_at DESC';
        if ($limit) {
            $query .= ' LIMIT :limit';
        }
        
        $this->db->query($query);
        if ($limit) {
            $this->db->bind('limit', $limit);
        }
        return $this->db->resultSet();
    }

    public function generateSlug($judul)
    {
        // Convert to lowercase and replace spaces with hyphens
        $slug = strtolower(trim($judul));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // Check if slug exists and add number if needed
        $originalSlug = $slug;
        $counter = 1;
        
        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    private function slugExists($slug)
    {
        $this->db->query('SELECT id_artikel FROM ' . $this->table . ' WHERE slug = :slug');
        $this->db->bind('slug', $slug);
        return $this->db->single() !== false;
    }

    public function upload()
    {
        $namaFile = $_FILES['gambar']['name'];
        $ukuranFile = $_FILES['gambar']['size'];
        $error = $_FILES['gambar']['error'];
        $tmpName = $_FILES['gambar']['tmp_name'];

        // Cek apakah tidak ada gambar yang diupload
        if( $error === 4 ) {
            return null; // Artikel bisa tanpa gambar
        }

        // Cek apakah yang diupload adalah gambar
        $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'gif'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
            echo "<script>
                    alert('yang anda upload bukan gambar!');
                  </script>";
            return false;
        }

        // Cek jika ukurannya terlalu besar (max 5MB untuk artikel)
        if( $ukuranFile > 5000000 ) {
            echo "<script>
                    alert('ukuran gambar terlalu besar! Maksimal 5MB');
                  </script>";
            return false;
        }

        // Lolos pengecekan, gambar siap diupload
        // Generate nama gambar baru
        $namaFileBaru = 'artikel_' . uniqid();
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