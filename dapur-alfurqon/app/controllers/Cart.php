<?php

class Cart extends Controller {
    public function index()
    {
        $data['title'] = 'Keranjang - Sistem Order';
        $data['cart'] = $this->model('Cart_model')->getCart();
        $data['total'] = $this->model('Cart_model')->getTotal();
        $data['cart_count'] = $this->model('Cart_model')->getCartCount();
        $this->view('home/cart', $data);
    }

    public function update()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_menu = $_POST['id_menu'];
            $jumlah = $_POST['jumlah'];
            
            $this->model('Cart_model')->updateCart($id_menu, $jumlah);
        }
        header('Location: ' . BASEURL . '/cart');
        exit;
    }

    public function remove($id_menu)
    {
        $this->model('Cart_model')->removeFromCart($id_menu);
        Flasher::setFlash('berhasil', 'dihapus dari keranjang', 'success');
        header('Location: ' . BASEURL . '/cart');
        exit;
    }
}
