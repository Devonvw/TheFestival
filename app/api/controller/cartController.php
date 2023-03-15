<?php
require __DIR__ . '/../../service/cartService.php';

class APICartController
{
    private $cartService;

    function __construct()
    {
        $this->cartService = new CartService();
    }

    

    public function createCart()
    {
        try {

            $this->cartService->createCart();
            echo json_encode(['msg' => "Created cart"]);
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
            echo json_encode(['msg' => "Item added to cart"]);
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
            echo json_encode(['msg' => "Item removed from cart"]);
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
            echo json_encode(['msg' => "Cart cleared"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function getCartTickets()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            echo json_encode($this->processCartRequest('getCartTickets', $body));
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function getCart()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            echo json_encode($this->processCartRequest('getCart', $body));
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
}
