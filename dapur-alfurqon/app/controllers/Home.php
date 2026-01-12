<?php

class Home extends Controller {
    public function index()
    {
        $data['title'] = 'Menu - Sistem Order';
        
        if(isset($_GET['keyword']) && !empty($_GET['keyword'])) {
            $data['menu'] = $this->model('Menu_model')->cariMenu($_GET['keyword']);
            $data['keyword'] = $_GET['keyword'];
        } else {
            $data['menu'] = $this->model('Menu_model')->getAllMenu();
        }
        
        $data['menu_terlaris'] = $this->model('Menu_model')->getMenuTerlaris(6);
        $data['cart_count'] = $this->model('Cart_model')->getCartCount();
        $this->view('home/index', $data);
    }

    public function addToCart()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_menu = $_POST['id_menu'];
            $menu = $this->model('Menu_model')->getMenuById($id_menu);
            
            if($menu && $menu['status'] == 'tersedia') {
                $cartModel = $this->model('Cart_model');
                $cartModel->addToCart(
                    $menu['id_menu'],
                    $menu['nama_menu'],
                    $menu['harga'],
                    $menu['gambar'],
                    isset($_POST['jumlah']) ? $_POST['jumlah'] : 1
                );
                
                Flasher::setFlash('berhasil', 'ditambahkan ke keranjang', 'success');
            }
        }
        header('Location: ' . BASEURL);
        exit;
    }

    public function cart()
    {
        // Redirect to new Cart controller
        header('Location: ' . BASEURL . '/cart');
        exit;
    }

    public function gallery()
    {
        // Redirect to new Gallery public controller
        header('Location: ' . BASEURL . '/gallery');
        exit;
    }

    public function team()
    {
        // Redirect to new Team controller
        header('Location: ' . BASEURL . '/team');
        exit;
    }
}
