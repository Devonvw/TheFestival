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
                        //Account routes
                    case "account/all":
                        //(new Middleware())->adminOnly();
                        require_once __DIR__ . '/api/controller/accountController.php';
                        $controller = new APIAccountController();
                        $controller->getAllAccounts();
                        break;
                    case "event/all":
                        //(new Middleware())->adminOnly();
                        require_once __DIR__ . '/api/controller/eventController.php';
                        $controller = new APIEventController();
                        $controller->getAllEvents();
                        break;

                        //Information pages routes
                    case "information-page":
                        //(new Middleware())->adminOnly();
                        require_once __DIR__ . '/api/controller/informationPageController.php';
                        $controller = new APIInformationPageController();
                        echo $controller->getInformationPages();
                        break;
                    case "information-page/page":
                        //(new Middleware())->adminOnly();
                        require_once __DIR__ . '/api/controller/informationPageController.php';
                        $controller = new APIInformationPageController();
                        echo $controller->getInformationPage($params["id"]);
                        break;
                    case "information-page/home-page":
                        require_once __DIR__ . '/api/controller/informationPageController.php';
                        $controller = new APIInformationPageController();
                        echo $controller->getHomePage();
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
                    case "information-page/edit-home-page":
                        //(new Middleware())->adminOnly();
                        require_once __DIR__ . '/api/controller/informationPageController.php';
                        $controller = new APIInformationPageController();
                        $controller->editHomePage();
                        break;
                    case "information-section":
                        (new Middleware())->adminOnly();
                        require_once __DIR__ . '/api/controller/informationPageController.php';
                        $controller = new APIInformationPageController();
                        $controller->addInformationSection($params["information_page_id"]);
                        break;
                        //User routes
                    case "user/sign-up":
                        require_once __DIR__ . '/api/controller/accountController.php';
                        $controller = new APIAccountController();
                        $controller->createUser();
                        break;
                    case "user/login":
                        session_start();
                        require_once __DIR__ . '/api/controller/accountController.php';
                        $controller = new APIAccountController();
                        $controller->login();
                        break;
                        //update-account in post because of image
                    case "update-account":
                        session_start();
                        (new Middleware())->loggedInOnly();
                        require_once __DIR__ . '/api/controller/accountController.php';
                        $controller = new APIAccountController();
                        $controller->updateAccountCustomer();
                        break;
                    case "user/reset/password":
                        session_start();
                        require_once __DIR__ . '/api/controller/PasswordResetcontroller.php';
                        $controller = new APIPasswordResetController();
                        $controller->resetPassword();
                        break;
                    case "user/reset/sendResetLink":
                        session_start();
                        require_once __DIR__ . '/api/controller/PasswordResetcontroller.php';
                        $controller = new APIPasswordResetController();
                        $controller->sendConfirmationMail();
                        break;
                    case "update-event":
                        session_start();
                        // (new Middleware())->adminOnly();
                        require_once __DIR__ . '/api/controller/eventController.php';
                        $controller = new APIEventController();
                        $controller->updateEvent();
                        break;

                    default:
                        http_response_code(404);
                        break;
                }
                break;
            case 'PUT':
                switch ($uri) {
                        //account routes
                    case "account":
                        //(new Middleware())->adminOnly();
                        require_once __DIR__ . '/api/controller/accountController.php';
                        $controller = new APIAccountController();
                        $controller->updateAccount($params["id"]);
                        break;
                    case "change-email":
                        session_start();
                        //(new Middleware())->loggedInOnly();
                        require_once __DIR__ . '/api/controller/accountController.php';
                        $controller = new APIAccountController();
                        $controller->updateEmailCustomer();
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
                        //Account routes
                    case "account":
                        //(new Middleware())->adminOnly();
                        require_once __DIR__ . '/api/controller/accountController.php';
                        $controller = new APIAccountController();
                        $controller->deleteAccount($params["id"]);
                        break;

                    case "event":
                        // (new Middleware())->adminOnly();
                        require_once __DIR__ . '/api/controller/eventController.php';
                        $controller = new APIEventController();
                        $controller->deleteEvent($params["id"]);
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
                    case '':
                        require __DIR__ . '/controller/homeController.php';
                        session_start();
                        $controller = new HomeController();
                        $controller->index();
                        break;

                    //Dashboard pages
                    case 'dashboard':
                        require __DIR__ . '/controller/dashboardController.php';
                        session_start();
                        $controller = new DashboardController();
                        $controller->index();
                        break;
                    case 'dashboard/accounts':
                        require __DIR__ . '/controller/dashboardController.php';
                        session_start();
                        $controller = new DashboardController();
                        $controller->accounts();
                        break;
                    case 'dashboard/accounts/edit':
                        require __DIR__ . '/controller/dashboardController.php';
                        session_start();
                        $controller = new DashboardController();
                        $controller->editAccount();
                        break;
                    case 'dashboard/restaurant':
                        require __DIR__ . '/controller/dashboardController.php';
                        session_start();
                        $controller = new DashboardController();
                        $controller->restaurant();
                        break;
                    case 'dashboard/content/home-page':
                        require __DIR__ . '/controller/dashboardController.php';
                        session_start();
                        $controller = new DashboardController();
                        $controller->contentHomePage();
                        break;
                    case 'dashboard/content/information-pages':
                        require __DIR__ . '/controller/dashboardController.php';
                        session_start();
                        $controller = new DashboardController();
                        $controller->contentInformationPages();
                        break;
                    case 'dashboard/content/information-pages/page':
                        require __DIR__ . '/controller/dashboardController.php';
                        session_start();
                        $controller = new DashboardController();
                        $controller->contentInformationPage();
                        break;
                    case 'login':
                        require __DIR__ . '/controller/userController.php';
                        session_start();
                        $controller = new UserController();
                        $controller->login();
                        break;
                    case 'login/reset/password':
                        require __DIR__ . '/controller/passwordResetController.php';
                        session_start();
                        $controller = new PasswordResetController();
                        $controller->resetPassword();
                        break;
                    case 'login/reset/email':
                        require __DIR__ . '/controller/passwordResetController.php';
                        session_start();
                        $controller = new PasswordResetController();
                        $controller->resetEmail();
                        break;
                    case 'login/reset/sendResetLink':
                        require __DIR__ . '/controller/passwordResetController.php';
                        session_start();
                        $controller = new PasswordResetController();
                        $controller->sendResetLink();
                        break;
                    case 'sign-up':
                        require __DIR__ . '/controller/userController.php';
                        session_start();
                        $controller = new UserController();
                        $controller->signUp();
                        break;
                        //customer account manager routes
                    case 'customer/manage-account':
                        require __DIR__ . '/controller/accountController.php';
                        session_start();
                        $controller = new AccountController();
                        $controller->accountManager();
                        break;
                    case 'customer/manage-account/change-password':
                        require __DIR__ . '/controller/accountController.php';
                        session_start();
                        $controller = new AccountController();
                        $controller->changePassword();
                        break;
                    case 'customer/manage-account/change-email':
                        require __DIR__ . '/controller/accountController.php';
                        session_start();
                        $controller = new AccountController();
                        $controller->changeEmail();
                        break;
                    case 'manage-event':
                        require __DIR__ . '/controller/eventController.php';
                        session_start();
                        $controller = new EventController();
                        $controller->eventManager();
                        break;
                        //Cart routes
                    case "cart":
                        require __DIR__ . '/controller/cartController.php';
                        session_start();
                        $controller = new CartController();
                        $controller->cart();
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