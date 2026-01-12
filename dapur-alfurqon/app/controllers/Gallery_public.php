<?php

class Gallery_public extends Controller {
    public function index()
    {
        $data['title'] = 'Gallery Foto';
        $data['gallery'] = $this->model('Gallery_model')->getActiveGallery();
        $data['cart_count'] = $this->model('Cart_model')->getCartCount();
        $this->view('home/gallery', $data);
    }
}
