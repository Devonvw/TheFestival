<?php 
require_once __DIR__ . '/../model/Account.php';
require_once __DIR__ . '/../model/Post.php';
require_once __DIR__ . '/../DAL/Database.php';

class Middleware {
    function adminOnly() {
        if ((isset($_SESSION["type"]) ? $_SESSION["type"] : 0) != 3) {
            http_response_code(500);
            echo json_encode([ 'msg' => "Only admins can call this route" ]);
        }
    }
}
?>