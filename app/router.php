<?php
require_once __DIR__ . '/middleware/middleware.php';

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
                    case "information-page":
                        require_once __DIR__ . '/api/controller/informationPageController.php';
                        $controller = new APIInformationPageController();
                        $controller->getInformationPages();
                        break;
                    case "account":
                        (new Middleware())->adminOnly();
                        require_once __DIR__ . '/api/controller/accountController.php';
                        $controller = new APIAccountController();
                        $controller->getAllAccounts();
                        break;
                    case "user/login":
                        require_once __DIR__ . '/api/controller/accountController.php';
                        $controller = new APIAccountController();
                        $controller->getUserAccount();
                        break;
                    default:
                        http_response_code(404);
                        break;
                }
                break;
            case 'POST':
                switch ($uri) {
                    case "information-page":
                        (new Middleware())->adminOnly();
                        require_once __DIR__ . '/api/controller/informationPageController.php';
                        $controller = new APIInformationPageController();
                        $controller->addInformationPage();
                        break;
                    case "information-section":
                        (new Middleware())->adminOnly();
                        require_once __DIR__ . '/api/controller/informationPageController.php';
                        $controller = new APIInformationPageController();
                        $controller->addInformationSection($params["information_page_id"]);
                        break;
                    case "user/sign-up":
                        require_once __DIR__ . '/api/controller/accountController.php';
                        $controller = new APIAccountController();
                        $controller->createUser();
                        break;
                    case "user/login":
                        require_once __DIR__ . '/api/controller/accountController.php';
                        $controller = new APIAccountController();
                        $controller->login();
                        break;
                    default:
                        http_response_code(404);
                        break;
                }
                break;
            case 'PUT':
                switch ($uri) {
                    case "account":
                        (new Middleware())->adminOnly();
                        require_once __DIR__ . '/api/controller/accountController.php';
                        $controller = new APIAccountController();
                        $controller->updateAccount($params["id"]);
                        break;
                    case "update-account":
                        require_once __DIR__ . '/api/controller/accountController.php';
                        $controller = new APIAccountController();
                        $controller->updateAccountCustomer($params["id"]);
                        break;
                    default:
                        http_response_code(404);
                        break;
                }
                break;
            case "DELETE":
                switch ($uri) {
                    case "information-page":
                        (new Middleware())->adminOnly();
                        require_once __DIR__ . '/api/controller/informationPageController.php';
                        $controller = new APIInformationPageController();
                        $controller->deleteInformationPage($params["id"]);
                        break;
                    case "information-section":
                        (new Middleware())->adminOnly();
                        require_once __DIR__ . '/api/controller/informationPageController.php';
                        $controller = new APIInformationPageController();
                        $controller->deleteInformationSection($params["id"]);
                        break;
                    case "account":
                        (new Middleware())->adminOnly();
                        require_once __DIR__ . '/api/controller/accountController.php';
                        $controller = new APIAccountController();
                        $controller->deleteAccount($params["id"]);
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
                    case 'dashboard/users':
                        require __DIR__ . '/controller/dashboardController.php';
                        session_start();
                        $controller = new DashboardController();
                        $controller->users();
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
                    case 'customer/manage-account':
                        require __DIR__ . '/controller/accountController.php';
                        session_start();
                        $controller = new AccountController();
                        $controller->accountManager();
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
