<?php
require_once __DIR__ . '/controller.php';
//require __DIR__ . '/../service/feedService.php';

class HomeController extends Controller {

    //private $feedService; 

    // initialize services
    function __construct() {
        //$this->feedService = new FeedService();
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