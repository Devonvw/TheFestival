<?php
require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../service/accountService.php';

class UserController extends Controller {
    private $userService; 

    // initialize services
    function __construct() {
        $this->userService = new AccountService();
    }

    public function login() {
        $this->displayView("");
    }

    public function signUp() {
      $this->displayView("");
    }

    public function myPosts() {
        $this->displayView("");
      }
}
?>