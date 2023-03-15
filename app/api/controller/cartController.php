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
            $this->cartService->createCart(isset($_SESSION['id']) ? $_SESSION['id'] : null, session_id());

            echo json_encode([ 'msg' => "Created cart" ]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }


    public function addToCart()
    {
        session_start();
        
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            $this->cartService->addToCart($body["ticket_id"], isset($_SESSION['id']) ? $_SESSION['id'] : null, session_id());
            echo json_encode([ 'msg' => "Item added to cart" ]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function removeFromCart()
    {
        session_start();

        try {
            $body = json_decode(file_get_contents('php://input'), true);
            $this->cartService->removeFromCart($body["cart_item_id"], isset($_SESSION['id']) ? $_SESSION['id'] : null, session_id());
            echo json_encode([ 'msg' => "Item removed from cart" ]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function clearCart()
    {
        try {
            $this->cartService->clearCart(isset($_SESSION['id']) ? $_SESSION['id'] : null, session_id());

            echo json_encode([ 'msg' => "Cart cleared" ]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function getCart()
    {
        session_start();
        
        try {
            echo json_encode($this->cartService->getCart(isset($_SESSION['id']) ? $_SESSION['id'] : null, session_id()));
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
}
