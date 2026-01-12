<?php

class Cart_model {
    
    public function __construct()
    {
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function addToCart($id_menu, $nama_menu, $harga, $gambar, $jumlah = 1)
    {
        if(isset($_SESSION['cart'][$id_menu])) {
            $_SESSION['cart'][$id_menu]['jumlah'] += $jumlah;
        } else {
            $_SESSION['cart'][$id_menu] = [
                'id_menu' => $id_menu,
                'nama_menu' => $nama_menu,
                'harga' => $harga,
                'gambar' => $gambar,
                'jumlah' => $jumlah
            ];
        }
        return true;
    }

    public function updateCart($id_menu, $jumlah)
    {
        if(isset($_SESSION['cart'][$id_menu])) {
            if($jumlah > 0) {
                $_SESSION['cart'][$id_menu]['jumlah'] = $jumlah;
            } else {
                unset($_SESSION['cart'][$id_menu]);
            }
            return true;
        }
        return false;
    }

    public function removeFromCart($id_menu)
    {
        if(isset($_SESSION['cart'][$id_menu])) {
            unset($_SESSION['cart'][$id_menu]);
            return true;
        }
        return false;
    }

    public function getCart()
    {
        return $_SESSION['cart'];
    }

    public function getCartCount()
    {
        return count($_SESSION['cart']);
    }

    public function getTotal()
    {
        $total = 0;
        foreach($_SESSION['cart'] as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }
        return $total;
    }

    public function clearCart()
    {
        $_SESSION['cart'] = [];
        return true;
    }

    public function isEmpty()
    {
        return empty($_SESSION['cart']);
    }
}
