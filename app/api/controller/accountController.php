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
            return json_encode($_SESSION);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function createUser()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $this->accountService->createUser($body["email"], $body["password"], $body["first_name"], $body["last_name"], $body["type_id"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function logout()
    {
        try {
            $this->accountService->logoutUser();
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function getAllAccounts()
    {
        try {
            session_start();

            return $this->accountService->getAllAccounts();
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function getUserAccount()
    {
        try {
            session_start();
            $userId = $_SESSION['id'];

            $account = $this->accountService->getUserAccount($userId);
            if($account)
            return $account;
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) {
                echo json_encode(['msg' => $ex->getMessage()]);
            }
        }
    }


    public function deleteAccount($id)
    {
        try {
            $this->accountService->deleteAccount($id);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function updateAccount($id)
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $this->accountService->updateAccount($id, $body["firstName"], $body["lastName"], $body["email"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function updateAccountCustomer($id)
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $this->accountService->updateAccountCustomer($id, $body["firstName"], $body["lastName"], $body["email"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
}
