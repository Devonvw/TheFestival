<?php
class Controller {
    
    function displayView($data) {        
        $directory = substr(get_class($this), 0, -10);
        $view = debug_backtrace()[1]['function'];
        require __DIR__ . "/../view/$directory/$view.php";
    }

    function adminOnly() {
        if ((isset($_SESSION["type_id"]) ? $_SESSION["type_id"] : 0) != 3) {
            header("location: /");
            exit;
        } 
    }

}