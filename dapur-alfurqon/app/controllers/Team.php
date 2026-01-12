<?php

class Team extends Controller {
    public function index()
    {
        $data['title'] = 'Tim Kami';
        $data['karyawan'] = $this->model('Karyawan_model')->getActiveKaryawan();
        $data['cart_count'] = $this->model('Cart_model')->getCartCount();
        $this->view('home/team', $data);
    }
}
