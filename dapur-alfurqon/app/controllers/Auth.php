<?php

class Auth extends Controller {
    public function index()
    {
        if(isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }

        $data['title'] = 'Login Page';
        $this->view('auth/login', $data);
    }

    public function login()
    {
        if(isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->model('User_model')->getUserByUsername($username);

            if($user) {
                if(password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id_user'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                    
                    header('Location: ' . BASEURL . '/dashboard');
                    exit;
                } else {
                    Flasher::setLoginFlash('Login Gagal', 'Password salah!', 'error');
                    header('Location: ' . BASEURL);
                    exit;
                }
            } else {
                Flasher::setLoginFlash('Login Gagal', 'Username tidak ditemukan!', 'error');
                header('Location: ' . BASEURL);
                exit;
            }
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . BASEURL);
        exit;
    }
}
