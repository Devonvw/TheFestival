<?php
require_once __DIR__ . '/controller.php';
require __DIR__ . '/../service/homeService.php';

class HomeController extends Controller {

    private $homeService; 

    // initialize services
    function __construct() {
        $this->homeService = new HomeService();
    }

    // router maps this to /article and /article/index automatically
    public function index() {
        $this->homeService->getInstagramFeed();
        $this->displayView("");
    }
}
?>