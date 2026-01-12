<?php

class Profile extends Controller {
    public function index()
    {
        $data['title'] = 'Profile';
        $data['cart_count'] = $this->model('Cart_model')->getCartCount();
        $data['artikel'] = $this->model('Artikel_model')->getArtikelPublished(8); // Ambil 8 artikel terbaru untuk grid 4 kolom
        $data['pengaturan'] = $this->model('Pengaturan_model')->getPengaturanForProfile();
        $data['misi_list'] = $this->model('Pengaturan_model')->getMisiArray();
        $this->view('profile/index', $data);
    }
}
