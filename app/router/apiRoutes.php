<?php
require_once __DIR__ . '/../middleware/middleware.php';

function handleApiRoutes($uri, $params, $requestMethod)
{
    switch ($requestMethod) {
        case 'GET':
            switch ($uri) {

                    /*----------------------GET Account routes-----------------------------*/

                case "account/all":
                    //(new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->getAllAccounts();
                    break;
                case "me":
                    session_start();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->getAccount($_SESSION["id"]);
                    break;
                case "event/all":
                    //(new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->getAllEvents();
                    break;

                    /*----------------------GET information pages routes-----------------------------*/

                case "information-page":
                    //(new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    echo $controller->getInformationPages();
                    break;
                case "information-page/page":
                    //(new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    echo $controller->getInformationPage(isset($params["id"]) ? $params["id"] : null, isset($params["url"]) ? $params["url"] : null);
                    break;
                case "information-page/home-page":
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    echo $controller->getHomePage();
                    break;

/*----------------------GET information pages routes-----------------------------*/

                case "instagram-feed":
                    require_once __DIR__ . '/../api/controller/instagramController.php';
                    $controller = new APIInstagramController();
                    echo $controller->getInstagramFeed();
                    break;


                default:
                    http_response_code(404);
                    break;
            }
            break;
        case 'POST':
            switch ($uri) {

                    /*----------------------POST account routes-----------------------------*/

                case "user/sign-up":
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->createUser();
                    break;
                case "user/login":
                    session_start();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->login();
                    break;
                    //update-account in post because of image
                case "update-account":
                    session_start();
                   // (new Middleware())->loggedInOnly();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->updateAccountCustomer();
                    break;
                case "user/reset/password":
                    session_start();
                    require_once __DIR__ . '/../api/controller/PasswordResetcontroller.php';
                    $controller = new APIPasswordResetController();
                    $controller->resetPassword();
                    break;
                case "user/reset/sendResetLink":
                    session_start();
                    require_once __DIR__ . '/../api/controller/PasswordResetcontroller.php';
                    $controller = new APIPasswordResetController();
                    $controller->sendConfirmationMail();
                    break;
                case "update-event":
                    session_start();
                    // (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->updateEvent();
                    break;

                    /*----------------------POST information page routes-----------------------------*/

                    //Edit information page, only for admin
                case "information-page":
                    //(new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    $controller->addInformationPage();
                    break;
                    //Edit home page, only for admin
                case "information-page/edit-home-page":
                    //(new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    $controller->editHomePage();
                    break;
                    //Edit information page, only for admin
                case "information-page/edit-page":
                    //(new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    $controller->editInformationPage($params["id"]);
                    break;
                case "information-page/information-section":
                    //(new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    $controller->addInformationSection($params["information_page_id"]);
                    break;


                default:
                    http_response_code(404);
                    break;
            }
            break;
        case 'PUT':
            switch ($uri) {

                    /*----------------------PUT account routes-----------------------------*/

                case "account":
                    //(new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->updateAccount($params["id"]);
                    break;
                case "change-email":
                    session_start();
                    //(new Middleware())->loggedInOnly();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->updateEmailCustomer();
                    break;


                default:
                    http_response_code(404);
                    break;
            }
            break;
        case "DELETE":
            switch ($uri) {

                    /*----------------------DELETE account routes-----------------------------*/

                case "account":
                    //(new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->deleteAccount($params["id"]);
                    break;

                case "event":
                    // (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->deleteEvent($params["id"]);
                    break;

                    /*----------------------DELETE information pages routes-----------------------------*/

                case "information-page":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    $controller->deleteInformationPage($params["id"]);
                    break;
                case "information-section":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
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