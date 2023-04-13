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
        $this->adminOnly();
        
        $this->displayView("");
    }
    public function accounts() {
        $this->adminOnly();

        require __DIR__ . "/../view/Dashboard/accounts/index.php";
    }
    public function addAccount() {
        $this->adminOnly();

        require __DIR__ . "/../view/Dashboard/accounts/add.php";
    }
    public function editAccount() {
        $this->adminOnly();

        require __DIR__ . "/../view/Dashboard/accounts/edit.php";
    }
    public function contentHomePage() {
        $this->adminOnly();

        require __DIR__ . "/../view/Dashboard/content/homePage.php";
    }
    public function contentInformationPages() {
        $this->adminOnly();

        require __DIR__ . "/../view/Dashboard/content/informationPages/index.php";
    }
    public function contentInformationPage() {
        $this->adminOnly();

        require __DIR__ . "/../view/Dashboard/content/informationPages/page.php";
    }
    public function events() {
        $this->adminOnly();

        require __DIR__ . "/../view/Dashboard/events/index.php";
    }
    public function viewEventItems() {
        $this->adminOnly();
        require __DIR__ . "/../view/Dashboard/events/eventItems.php";
    }
    public function editEventItems() {
        $this->adminOnly();
        require __DIR__ . "/../view/Dashboard/events/editeventItems.php";
    }
    public function editEventItemSlot() {
        $this->adminOnly();
        require __DIR__ . "/../view/Dashboard/events/editEventItemSlots.php";
    }
    public function addEventItemSlot() {
        $this->adminOnly();
        require __DIR__ . "/../view/Dashboard/events/addEventItemSlot.php";
    }
    public function eventItemTickets() {
        $this->adminOnly();
        require __DIR__ . "/../view/Dashboard/events/eventItemTickets.php";
    }
    public function editEventItemTicket() {
        $this->adminOnly();
        require __DIR__ . "/../view/Dashboard/events/editEventItemTickets.php";
    }
    public function addEventItemTicket() {
        $this->adminOnly();
        require __DIR__ . "/../view/Dashboard/events/addEventItemTicket.php";
    }
    public function eventItemSlots() {
        $this->adminOnly();
        require __DIR__ . "/../view/Dashboard/events/eventItemSlots.php";
    }
    public function allOrders() {
        $this->adminOnly();

        require __DIR__ . "/../view/Dashboard/orders/index.php";
    }
    public function editOrder() {
        $this->adminOnly();

        require __DIR__ . "/../view/Dashboard/orders/edit.php";
    }
}
?>