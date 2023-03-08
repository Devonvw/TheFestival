<?php
require_once __DIR__ . '/../middleware/middleware.php';

function handleRoutes($uri, $requestMethod, $content)
    {
        if ($requestMethod != "GET") http_response_code(404);

        if ($content) {
            require __DIR__ . '/../controller/informationPageController.php';
                session_start();
                $controller = new InformationPageController();
                $controller->index($uri);
        }

        switch ($uri) {

/*----------------------Content routes-----------------------------*/

            case '':
                require __DIR__ . '/../controller/homeController.php';
                session_start();
                $controller = new HomeController();
                $controller->index();
                break;

/*----------------------Dashboard routes-----------------------------*/
            
            case 'dashboard':
                require __DIR__ . '/../controller/dashboardController.php';
                session_start();
                $controller = new DashboardController();
                $controller->index();
                break;
            case 'dashboard/accounts':
                require __DIR__ . '/../controller/dashboardController.php';
                session_start();
                $controller = new DashboardController();
                $controller->accounts();
                break;
            case 'dashboard/accounts/edit':
                require __DIR__ . '/../controller/dashboardController.php';
                session_start();
                $controller = new DashboardController();
                $controller->editAccount();
                break;
            case 'dashboard/restaurant':
                require __DIR__ . '/../controller/dashboardController.php';
                session_start();
                $controller = new DashboardController();
                $controller->restaurant();
                break;
            case 'dashboard/content/home-page':
                require __DIR__ . '/../controller/dashboardController.php';
                session_start();
                $controller = new DashboardController();
                $controller->contentHomePage();
                break;
            case 'dashboard/content/information-pages':
                require __DIR__ . '/../controller/dashboardController.php';
                session_start();
                $controller = new DashboardController();
                $controller->contentInformationPages();
                break;
            case 'dashboard/content/information-pages/page':
                require __DIR__ . '/../controller/dashboardController.php';
                session_start();
                $controller = new DashboardController();
                $controller->contentInformationPage();
                break;

/*----------------------Account routes-----------------------------*/

            case 'login':
                require __DIR__ . '/../controller/userController.php';
                session_start();
                $controller = new UserController();
                $controller->login();
                break;
            case 'login/reset/password':
                require __DIR__ . '/../controller/passwordResetController.php';
                session_start();
                $controller = new PasswordResetController();
                $controller->resetPassword();
                break;
            case 'login/reset/email':
                require __DIR__ . '/../controller/passwordResetController.php';
                session_start();
                $controller = new PasswordResetController();
                $controller->resetEmail();
                break;
            case 'login/reset/sendResetLink':
                require __DIR__ . '/../controller/passwordResetController.php';
                session_start();
                $controller = new PasswordResetController();
                $controller->sendResetLink();
                break;
            case 'sign-up':
                require __DIR__ . '/../controller/userController.php';
                session_start();
                $controller = new UserController();
                $controller->signUp();
                break;
                //customer account manager routes
            case 'customer/manage-account':
                require __DIR__ . '/../controller/accountController.php';
                session_start();
                $controller = new AccountController();
                $controller->accountManager();
                break;
            case 'customer/manage-account/change-password':
                require __DIR__ . '/../controller/accountController.php';
                session_start();
                $controller = new AccountController();
                $controller->changePassword();
                break;
            case 'customer/manage-account/change-email':
                require __DIR__ . '/../controller/accountController.php';
                session_start();
                $controller = new AccountController();
                $controller->changeEmail();
                break;

/*----------------------Event routes-----------------------------*/

            case 'manage-event':
                require __DIR__ . '/../controller/eventController.php';
                session_start();
                $controller = new EventController();
                $controller->eventManager();
                break;

/*----------------------Cart routes-----------------------------*/

            case "cart":
                require __DIR__ . '/../controller/cartController.php';
                session_start();
                $controller = new CartController();
                $controller->cart();
                break;

                
            default:
                http_response_code(404);
                break;
        }
    }