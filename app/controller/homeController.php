<?php
require_once __DIR__ . '/controller.php';

class HomeController extends Controller {


    // initialize services
    function __construct() {
    }

    // router maps this to /article and /article/index automatically
    public function index() {
        $this->displayView("");
    }
}
?>