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
        require __DIR__ . "/../view/Dashboard/accounts/index.php";
    }
    public function editAccount() {
        require __DIR__ . "/../view/Dashboard/accounts/edit.php";
    }
    public function restaurant() {
        require __DIR__ . "/../view/Dashboard/Food/index.php";
    }
}
?>