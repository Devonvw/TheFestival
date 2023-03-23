<?php 
require_once __DIR__ . '/../model/Account.php';
require_once __DIR__ . '/../DAL/Database.php';

class Middleware {
    function adminOnly() {
        if ((isset($_SESSION["type"]) ? $_SESSION["type"] : 0) != 3) {
            http_response_code(500);
            echo json_encode([ 'msg' => "Only admins can call this route" ]);
        }
    }
    function loggedInOnly() {
        if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]) {
            http_response_code(500);
            echo json_encode([ 'msg' => "Only logged in can call this route" ]);
        }
    }
    public function validToken() {
        if (!isset($_SESSION['token']) || !$_SESSION['token']) {
            http_response_code(500);
            json_encode(['msg' => "Token is invalid or has expired"]);
        }
    }
}
?>