<?php

class Artikel extends Controller {
    
    public function index()
    {
        $data['title'] = 'Artikel - Dapur Al-Furqon';
        $data['artikel'] = $this->model('Artikel_model')->getArtikelPublished();
        $this->view('artikel/public_index', $data);
    }

    public function detail($slug)
    {
        $artikel = $this->model('Artikel_model')->getArtikelBySlug($slug);
        
        if (!$artikel || $artikel['status'] !== 'published') {
            header('HTTP/1.0 404 Not Found');
            $data['title'] = '404 - Artikel Tidak Ditemukan';
            $this->view('errors/404', $data);
            return;
        }

        $data['title'] = $artikel['judul'] . ' - Dapur Al-Furqon';
        $data['artikel'] = $artikel;
        $data['artikel_lainnya'] = $this->model('Artikel_model')->getArtikelPublished(3);
        $this->view('artikel/public_detail', $data);
    }

    public function kategori($kategori)
    {
        $data['title'] = 'Artikel ' . ucfirst($kategori) . ' - Dapur Al-Furqon';
        $data['kategori'] = $kategori;
        
        // Filter artikel berdasarkan kategori
        $semua_artikel = $this->model('Artikel_model')->getArtikelPublished();
        $data['artikel'] = array_filter($semua_artikel, function($artikel) use ($kategori) {
            return $artikel['kategori'] === $kategori;
        });
        
        $this->view('artikel/public_kategori', $data);
    }
}