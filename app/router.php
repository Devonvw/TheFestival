<?php
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
        if ($api) $this->handleApiRoutes($uri, $params, $requestMethod);
        else $this->handleRoutes($uri, $requestMethod);
    }

    private function handleApiRoutes($uri, $params, $requestMethod)
    {
        switch ($requestMethod) {
            case 'GET':
                switch ($uri) {
                    case "information-pages":
                        require_once __DIR__ . '/api/controller/informationPageController.php';
                        $controller = new APIInformationPageController();
                        $controller->getInformationPages();
                        break;
                    case "user/login":
                        require_once __DIR__ . '/api/controller/informationPageController.php';
                        $controller = new APIInformationPageController();
                        $controller->getInformationPages();
                        break;
                    default:
                        http_response_code(404);
                        break;
                }
                break;
            case 'POST':
                switch ($uri) {
                    case "information-page":
                        require_once __DIR__ . '/api/controller/informationPageController.php';
                        $controller = new APIInformationPageController();
                        $controller->addInformationPage();
                        break;
                    case "information-section":
                        require_once __DIR__ . '/api/controller/informationPageController.php';
                        $controller = new APIInformationPageController();
                        $controller->addInformationSection($params["information_page_id"]);
                        break;
                    case "user/signup":
                        require_once __DIR__ . '/api/controller/userController.php';
                        $controller = new APIUserController();
                        $controller->createUser();
                        break;
                    default:
                        http_response_code(404);
                        break;
                }
                break;
            case "DELETE":
                switch ($uri) {
                    case "information-page":
                        require_once __DIR__ . '/api/controller/informationPageController.php';
                        $controller = new APIInformationPageController();
                        $controller->deleteInformationPage($params["id"]);
                        break;
                    case "information-section":
                        require_once __DIR__ . '/api/controller/informationPageController.php';
                        $controller = new APIInformationPageController();
                        $controller->deleteInformationSection($params["id"]);
                        break;
                    default:
                        http_response_code(404);
                        break;
                }
                break;
            default:
                http_response_code(404);
                break;
        }
    }

    private function handleRoutes($uri, $requestMethod)
    {
        switch ($requestMethod) {
            case 'GET':
                switch ($uri) {
                    case 'dashboard':
                        require __DIR__ . '/controller/dashboardController.php';
                        session_start();
                        $controller = new DashboardController();
                        $controller->index();
                        break;
                    case 'login':
                        require __DIR__ . '/controller/userController.php';
                        session_start();
                        $controller = new UserController();
                        $controller->login();
                        break;
                    case 'sign-up':
                        require __DIR__ . '/controller/userController.php';
                        session_start();
                        $controller = new UserController();
                        $controller->signUp();
                        break;
                    default:
                        http_response_code(404);
                        break;
                }
                break;

            default:
                http_response_code(404);
                break;
        }
    }
}
