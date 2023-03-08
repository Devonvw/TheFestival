<?php
require_once __DIR__ . '/../middleware/middleware.php';
require_once __DIR__ . '/../router/apiRoutes.php';
require_once __DIR__ . '/../router/pageRoutes.php';

class Router
{
    public function route($uri, $params, $requestMethod)
    {
        $api = false;
        if (str_starts_with($uri, "api/")) {
            $uri = substr($uri, 4);
            $api = true;
        }

        //Separate api routes and site routes
        if ($api) handleApiRoutes($uri, $params, $requestMethod);
        else handleRoutes($uri, $requestMethod);
    }
}