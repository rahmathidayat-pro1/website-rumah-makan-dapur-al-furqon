<?php

// This controller is kept for backward compatibility
// All admin gallery functions are now in Dashboard controller
// Public gallery is handled by Gallery_public controller

class Gallery extends Controller {
    public function __construct()
    {
        // This should not be called directly anymore
        // App.php routes /gallery to Gallery_public
    }

    public function index() {
        // Redirect to dashboard gallery if logged in
        if(isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/dashboard/gallery');
            exit;
        }
    }
    
    public function tambah() {
        if(isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/dashboard/gallery/tambah');
            exit;
        }
        header('Location: ' . BASEURL);
        exit;
    }
    
    public function simpan() {
        if(isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/dashboard/gallery');
            exit;
        }
        header('Location: ' . BASEURL);
        exit;
    }
    
    public function edit($id = null) {
        if(isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/dashboard/gallery/edit/' . $id);
            exit;
        }
        header('Location: ' . BASEURL);
        exit;
    }
    
    public function update() {
        if(isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/dashboard/gallery');
            exit;
        }
        header('Location: ' . BASEURL);
        exit;
    }
    
    public function hapus($id = null) {
        if(isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/dashboard/gallery/hapus/' . $id);
            exit;
        }
        header('Location: ' . BASEURL);
        exit;
    }
}
