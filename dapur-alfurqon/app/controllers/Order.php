<?php

class Order extends Controller {
    public function __construct()
    {
        // Redirect all order requests to dashboard/order
        if(isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/dashboard/order');
            exit;
        } else {
            header('Location: ' . BASEURL);
            exit;
        }
    }

    public function index() {}
    public function detail($id = null) {}
    public function updateStatus() {}
    public function updatePayment() {}
}
