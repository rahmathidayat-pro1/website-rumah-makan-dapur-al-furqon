<?php

class Menu extends Controller {
    public function __construct()
    {
        // Redirect all menu requests to dashboard/menu
        if(isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/dashboard/menu');
            exit;
        } else {
            header('Location: ' . BASEURL);
            exit;
        }
    }

    public function index() {}
    public function tambah() {}
    public function simpan() {}
    public function edit($id = null) {}
    public function update() {}
    public function hapus($id = null) {}
}
