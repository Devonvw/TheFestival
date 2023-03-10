<?php
require __DIR__ . '/../../service/cartService.php';

class APICartController
{
    private $cartService;

    function __construct()
    {
        $this->cartService = new CartService();
    }

    private function processCartRequest($function, $body)
    {
        if (isset($body["account_id"])) {
            $account_id = $body["account_id"];
            $session_id = session_id();
        } else {
            $account_id = null;
            $session_id = session_id();
        }

        $ticket_id = isset($body["ticket_id"]) ? $body["ticket_id"] : null;

        switch ($function) {
            case 'createCart':
                $this->cartService->createCart($account_id, $session_id);
                break;
            case 'addToCart':
                $this->cartService->addToCart($ticket_id, $account_id, $session_id);
                break;
            case 'removeFromCart':
                $this->cartService->removeFromCart($ticket_id, $account_id, $session_id);
                break;
            case 'clearCart':
                $this->cartService->clearCart($account_id, $session_id);
                break;
            case 'getCartTickets':
                $this->cartService->getCartTickets($account_id, $session_id);
                break;
            case 'getCart':
                $this->cartService->getCart($account_id, $session_id);
                break;
            default:
                throw new Exception("Invalid function specified.");
        }
    }

    public function createCart()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            $this->processCartRequest('createCart', $body);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function addToCart()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            $this->processCartRequest('addToCart', $body);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function removeFromCart()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            $this->processCartRequest('removeFromCart', $body);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function clearCart()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            $this->processCartRequest('clearCart', $body);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function getCartTickets()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            $this->processCartRequest('getCartTickets', $body);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function getCart()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            $this->processCartRequest('getCart', $body);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
}