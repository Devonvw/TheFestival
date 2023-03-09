<?php
require_once __DIR__ . '/../middleware/middleware.php';
require_once __DIR__ . '/../router/apiRoutes.php';
require_once __DIR__ . '/../router/pageRoutes.php';

class Router
{
    public function route($uri, $params, $requestMethod)
    {
        $content = false;

        //Handle API routes
        if (str_starts_with($uri, "api/")) {
            $uri = substr($uri, 4);
            handleApiRoutes($uri, $params, $requestMethod);
        }

        //Handle content routes
        if (str_starts_with($uri, "content/")) {
            $uri = substr($uri, 8);
            $content = true;
        }

        handleRoutes($uri, $requestMethod, $content);
    }
}