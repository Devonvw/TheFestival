<?php
require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../service/cartService.php';

class OrderController extends Controller
{
    function __construct()
    {
        
    }
    
    public function index() {
        $this->displayView("");
    }
}