<?php
require __DIR__ . '/../../service/passwordResetService.php';

class APIPasswordResetController
{
    private $passwordResetService;

    // initialize services
    function __construct()
    {
        $this->passwordResetService = new PasswordResetService();
    }

    public function sendConfirmationMail()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $this->passwordResetService->sendConfirmationMail($body["email"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function resetPassword($token)
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            $token = $body['token'];
            $this->passwordResetService->resetPassword($body['token'], $body["password"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
}