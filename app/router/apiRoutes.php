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

                    /*----------------------GET information pages routes-----------------------------*/
               
                case "cart/tickets":
                    //(new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/cartController.php';
                    $controller = new APICartController();
                    $controller->getCart();
                    break;
                default:
                    http_response_code(404);
                    break;
            }
            break;
        case 'POST':
            switch ($uri) {

                    /*----------------------POST account routes-----------------------------*/

                case "account/sign-up":
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->createAccount();
                    break;
                case "account/login":
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


                case "account/reset/password":
                    session_start();
                    require_once __DIR__ . '/../api/controller/PasswordResetcontroller.php';
                    $controller = new APIPasswordResetController();
                    $controller->resetPassword();
                    break;
                case "account/reset/sendResetLink":
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
                    $controller->updateEvent($params["id"]);
                    break;
                case "event":
                    session_start();
                    // (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->addEvent();
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

                    /*----------------------POST cart routes-----------------------------*/

                case "cart/create":
                    //(new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/cartController.php';
                    $controller = new APICartController();
                    $controller->createCart();
                    break;
                case "cart/add":
                    //(new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/cartController.php';
                    $controller = new APICartController();
                    $controller->addToCart();
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

                case "me/change-email":
                    session_start();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->updateEmailCustomer();
                    break;
                case "me/change-password":
                    session_start();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->updatePasswordCustomer();
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
                    //(new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    $controller->deleteInformationPage($params["id"]);
                    break;

                case "information-page/information-section":
                    //(new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    $controller->deleteInformationSection($params["id"]);
                    break;

                    /*----------------------DELETE cart routes-----------------------------*/

                case "cart/remove":
                    //(new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/cartController.php';
                    $controller = new APICartController();
                    $controller->removeFromCart();
                    break;
                case "cart/clear":
                    //(new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/cartController.php';
                    $controller = new APICartController();
                    $controller->clearCart();
                    break;
                default:
                    http_response_code(404);
                    break;
            }
            break;
        default:
            echo "help";
            http_response_code(404);
            break;
    }
}
