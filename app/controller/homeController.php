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
    public function festival()
    {
        require __DIR__ . "/../view/Event/festival.php";
    }
    public function jazz()
    {
        require __DIR__ . "/../view/Event/Music/jazz.php";
    }
    public function dance()
    {
        require __DIR__ . "/../view/Event/Music/dance.php";
    }
}