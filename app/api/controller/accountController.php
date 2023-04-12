<?php
require __DIR__ . '/../../service/accountService.php';

class APIAccountController
{
    private $accountService;

    // initialize services
    function __construct()
    {
        $this->accountService = new AccountService();
    }

    public function login()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            $this->accountService->loginUser($body["email"], $body["password"]);
            echo json_encode($_SESSION);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function createAccount()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            $this->accountService->createUser($body["email"], $body["password"], $body["first_name"], $body["last_name"], $body["type_id"], $body["recaptchaToken"]);
            echo json_encode(['msg' => "Account successfully created, you can now login"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }


    public function logout()
    {
        try {
            $this->accountService->logoutUser();
            echo json_encode(['msg' => "successfully logged out"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function getAllAccounts()
    {
        try {
            session_start();
            echo json_encode($this->accountService->getAllAccounts());
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function getAccount($id)
    {
        try {
            header('Content-Type: application/json');
            echo json_encode($this->accountService->getAccount($id));
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function deleteAccount($id)
    {
        try {
            $this->accountService->deleteAccount($id);
            echo json_encode(['msg' => "Account deleted"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function setAccountActive($id)
    {
        try {
            $this->accountService->setAccountActive($id);
            echo json_encode(['msg' => "Account is active"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function updateAccount($id)
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $this->accountService->updateAccount($id, $body["first_name"], $body["last_name"], $body["email"]);
            echo json_encode(['msg' => "Account updated"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function updateAccountCustomer()
    {
        try {
            $image = $_FILES ? ($_FILES["profile_picture"]["name"] ? $_FILES["profile_picture"] : false) : false;
            $this->accountService->updateAccountCustomer($_POST["first_name"], $_POST["last_name"], $image);
            echo json_encode(['msg' => "Account updated"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function updateEmailCustomer()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            $this->accountService->updateEmailCustomer($body["new_email"], $body["new_email_confirmation"], $body["password"]);

            echo json_encode(['msg' => "Email updated"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function updatePasswordCustomer()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            $this->accountService->updatePasswordCustomer($body["current_password"], $body["new_password"], $body["confirm_password"]);

            echo json_encode(['msg' => "Password updated"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function sendConfirmationMail()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $this->accountService->sendConfirmationMail($body["email"]);
            echo json_encode(['msg' => "Confirmation mail sent"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function resetPassword()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            $this->accountService->resetPassword($body["password"], $body['password_confirm']);
            echo json_encode(['msg' => "Password updated"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
}
