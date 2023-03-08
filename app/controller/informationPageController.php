<?php
require_once __DIR__ . '/controller.php';
require __DIR__ . '/../service/informationPageService.php';

class InformationPageController extends Controller {

    private $informationPageService; 

    // initialize services
    function __construct() {
        $this->informationPageService = new InformationPageService();
    }

    public function index($uri) {
        if (!$this->informationPageService->checkIfInformationPage($uri)) return http_response_code(404);
        
        require __DIR__ . "/../view/Dashboard/index.php";
    }
}
?>