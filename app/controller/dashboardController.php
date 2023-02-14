<?php
require_once __DIR__ . '/controller.php';
//require __DIR__ . '/../service/feedService.php';

class DashboardController extends Controller {

    //private $feedService; 

    // initialize services
    function __construct() {
        //$this->feedService = new FeedService();
    }

    // router maps this to /article and /article/index automatically
    public function index() {
        $this->displayView("");
    }
    public function accounts() {
        $this->displayView("");
    }
}
?>