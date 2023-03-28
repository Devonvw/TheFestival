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
    public function contentHomePage() {
        require __DIR__ . "/../view/Dashboard/content/homePage.php";
    }
    public function contentInformationPages() {
        require __DIR__ . "/../view/Dashboard/content/informationPages/index.php";
    }
    public function contentInformationPage() {
        require __DIR__ . "/../view/Dashboard/content/informationPages/page.php";
    }
    public function events() {
        require __DIR__ . "/../view/Dashboard/events/index.php";
    }
    public function viewEventItems() {
        require __DIR__ . "/../view/Dashboard/events/eventItems.php";
    }
    public function editEventItems() {
        require __DIR__ . "/../view/Dashboard/events/editeventItems.php";
    }
    public function allOrders() {
        require __DIR__ . "/../view/Dashboard/orders/index.php";
    }
    public function editOrder() {
        require __DIR__ . "/../view/Dashboard/orders/edit.php";
    }
}
?>