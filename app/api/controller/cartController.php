<?php
require __DIR__ . '/../../service/cartService.php';

class APICartController
{
    private $cartService;

    // initialize services
    function __construct()
    {
        $this->cartService = new CartService();
    }

    public function createCart()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $this->cartService->createCart($body["account_id"], $body["session_id"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

}