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
}