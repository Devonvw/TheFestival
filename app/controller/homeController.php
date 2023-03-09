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
    public function food() {
        require __DIR__ . "/../view/Home/Events/Food/index.php";
    }
    public function culture() {
        require __DIR__ . "/../view/Home/Events/Culture/index.php";
    }
    public function festival() {
        require __DIR__ . "/../view/Home/Events/Festival/index.php";
    }
}
?>