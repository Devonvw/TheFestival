<?php
require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../service/passwordResetService.php';

class PasswordResetController extends Controller
{
  private $passwordResetService;

  // initialize services
  function __construct()
  {
    $this->passwordResetService = new PasswordResetService();
  }
  public function resetPassword()
  {
    $this->displayView("");
  }
  public function resetEmail()
  {
    $this->displayView("");
  }
  public function sendResetLink()
  {
    $this->displayView("");
  }
}
