<?php
require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../service/accountService.php';

class AccountController extends Controller
{
  private $userService;

  // initialize services
  function __construct()
  {
    $this->userService = new AccountService();
  }
  public function login()
  {
    $this->displayView("");
  }

  public function signUp()
  {
    $this->displayView("");
  }
  public function accountManager()
  {
    $this->displayView("");
  }
  public function changeEmail()
  {
    $this->displayView("");
  }
  public function changePassword()
  {
    $this->displayView("");
  }

}
?>