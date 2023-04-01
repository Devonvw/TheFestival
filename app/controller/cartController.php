<?php
require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../service/cartService.php';

class CartController extends Controller
{
    function __construct()
    {
        
    }
    public function cart() {
        $this->displayView("");
    }
    public function checkout() {
        $this->displayView("");
    }
    public function orderOverview() {
        $this->displayView("");
    }
    public function shared() {
        $this->displayView("");
    }

    public function checkoutShared() {
        $this->displayView("");
    }
}