<?php
require_once __DIR__ . '/controller.php';

class HomeController extends Controller
{


    // initialize services
    function __construct()
    {
    }

    // router maps this to /article and /article/index automatically
    public function index()
    {
        $this->displayView("");
    }

    public function jazz()
    {
        require __DIR__ . "/../view/Home/Events/Music/jazz.php";
    }
    public function dance()
    {
        require __DIR__ . "/../view/Home/Events/Music/dance.php";
    }
}