<?php
require_once __DIR__ . '/../middleware/middleware.php';

function handleApiRoutes($uri, $params, $requestMethod)
{
    switch ($requestMethod) {
        case 'GET':
            switch ($uri) {

                    /*----------------------GET Account routes-----------------------------*/
                    //retrieve all accounts, only admin can view this
                case "account/all":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->getAllAccounts();
                    break;
                    //retrieve account by id
                case "me":
                    session_start();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->getAccount($_SESSION["id"]);
                    break;

                    /*----------------------GET Event routes-----------------------------*/
                    //retrieve all events
                case "event/main-events":
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->getMainEvents();
                    break;
                    //retrieve all event items by main event, only admin can view this
                case "event/event-items":
                    session_start();
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->getEventItems($params["id"]);
                    break;
                    //retrieve eventitem by main event, only admin can view this
                case "event/event-item":
                    session_start();
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->getEventItem($params["id"]);
                    break;
                    //retrieve all event item slots, only admin can view this
                case "events/event-items/slots":
                    session_start();
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->getEventItemSlots();
                    break;
                    //retrieve all event item slots based on eventitemid, only admin can view this
                case "event/event-item/slots":
                    session_start();
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->getEventItemSlotsByEventItemId($params["id"]);
                    break;
                    //retrieve all event item tickets, only admin can view this
                case "event/event-item/tickets":
                    session_start();
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->getEventItemTickets();
                    break;
                    //retrieve event item ticket by id, only admin can view this
                case "event/event-item/ticket":
                    session_start();
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->getEventItemTicketById($params["id"]);
                    break;
                    //retrieve event item slot by id, only admin can view this
                case "event/event-item/slot":
                    session_start();
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->getEventItemSlotById($params["id"]);
                    break;


                    /*----------------------GET Information pages routes-----------------------------*/

                    //Retrieve all information pages for the dashboard. Admin only
                case "information-page":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    $controller->getInformationPages();
                    break;

                    //Retrieve all information pages for the navbar and footer. Open for everyone
                case "information-page/urls":
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    $controller->getInformationPageUrls();
                    break;

                    //Retrieve a single information page for the dashboard and website. Open for everyone
                case "information-page/page":
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    $controller->getInformationPage(isset($params["id"]) ? $params["id"] : null, isset($params["url"]) ? $params["url"] : null);
                    break;

                    //Retrieve the home page for the dashboard and website. Open for everyone
                case "information-page/home-page":
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    $controller->getHomePage();
                    break;

                    /*----------------------------------------GET Instagram routes-----------------------------*/

                    //Retrieve the instagram feed for the home page. Open for everyone
                case "instagram-feed":
                    require_once __DIR__ . '/../api/controller/instagramController.php';
                    $controller = new APIInstagramController();
                    $controller->getInstagramFeed();
                    break;

                    /*----------------------------------------GET Cart routes-----------------------------*/

                    //Retrieve a cart. Open for everyone
                case "cart":
                    require_once __DIR__ . '/../api/controller/cartController.php';
                    $controller = new APICartController();
                    $controller->getCart(isset($params["token"]) ? $params["token"] : null);
                    break;


                    //Create a link of your own cart to share with someone else. Open for everyone
                case "cart/share-link":
                    require_once __DIR__ . '/../api/controller/cartController.php';
                    $controller = new APICartController();
                    $controller->getCartShareLink();
                    break;


                    /*----------------------GET Order routes-----------------------------*/

                    //Retrieve order by id. Open for everyone
                case "order":
                    require_once __DIR__ . '/../api/controller/orderController.php';
                    $controller = new APIOrderController();
                    $controller->getOrder(isset($params["id"]) ? $params["id"] : null);
                    break;

                    //Retrieve all orders. Admin only
                case "order/all":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/orderController.php';
                    $controller = new APIOrderController();
                    $controller->getAllOrders();
                    break;

                    //Retrieve order status by id. Open for everyone
                case "order/status":
                    require_once __DIR__ . '/../api/controller/orderController.php';
                    $controller = new APIOrderController();
                    $controller->getOrderStatus(isset($params["id"]) ? $params["id"] : null);
                    break;

                    //Retrieve all orders by event. Admin only
                case "order/event/all":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/orderController.php';
                    $controller = new APIOrderController();
                    $controller->getEventOrders();
                    break;

                    /*----------------------GET payment routes-----------------------------*/

                    //Retrieve all ideal issuers. Open for everyone
                case "payment/ideal-issuers":
                    require_once __DIR__ . '/../api/controller/paymentController.php';
                    $controller = new APIPaymentController();
                    $controller->getIdealIssuers();
                    break;

                    /*----------------------GET invoice routes-----------------------------*/

                    //Retrieve invoice by order id. Admin only
                case "invoice":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/invoiceController.php';
                    $controller = new APIInvoiceController();
                    $controller->getInvoice(isset($params["orderId"]) ? $params["orderId"] : null);
                    break;

                default:
                    http_response_code(404);
                    break;
            }
            break;
        case 'POST':
            switch ($uri) {

                    /*----------------------POST account routes-----------------------------*/
                    //create account, used for customer and admin
                case "account/create":
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->createAccount();
                    break;
                    //login, used for customer and admin
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
                    //update-account in post because of image
                case "account/reset/password":
                    session_start();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->resetPassword();
                    break;
                    //sending a reset link to the email
                case "account/reset/sendResetLink":
                    session_start();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->sendConfirmationMail();
                    break;
                    //logout   
                case "account/logout":
                    session_start();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->logout();
                    break;

                    /*----------------------POST event routes-----------------------------*/
                    //create event
                case "event/event-item/add":
                    session_start();
                    // (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->addEventItem();
                    break;
                    //edit event
                case "event/event-item/edit":
                    session_start();
                    // (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->editEventItem($params["id"]);
                    break;
                    //edit event item slot
                case "event/event-item/slot/edit":
                    session_start();
                    // (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->editEventItemSlot($params["id"]);
                    break;
                    //add event item slot
                case "event/event-item/slot/add":
                    session_start();
                    // (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->addEventItemSlot();
                    break;
                    //edit event item ticket
                case "event/event-item/ticket/edit":
                    session_start();
                    // (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->editEventItemTicket($params["id"]);
                    break;
                    //add event item ticket
                case "event/event-item/ticket/add":
                    session_start();
                    // (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->addEventItemTicket();
                    break;



                    /*----------------------POST information page routes-----------------------------*/

                    //Edit information page. Admin only
                case "information-page":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    $controller->addInformationPage();
                    break;

                    //Edit home page. Admin only
                case "information-page/edit-home-page":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    $controller->editHomePage();
                    break;

                    //Edit information page. Admin only
                case "information-page/edit-page":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    $controller->editInformationPage(isset($params["id"]) ? $params["id"] : null);
                    break;

                    //Add information section to page. Admin only
                case "information-page/information-section":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    $controller->addInformationSection(isset($params["information_page_id"]) ? $params["information_page_id"] : null);
                    break;


                    /*----------------------POST payment routes-----------------------------*/


                    //Create payment and order. Open for everyone
                case "payment":
                    require_once __DIR__ . '/../api/controller/paymentController.php';
                    $controller = new APIPaymentController();
                    $controller->createPayment(isset($params["token"]) ? $params["token"] : null);
                    break;

                    //Webhook for mollie payment. Open for everyone
                case "payment/status":
                    require_once __DIR__ . '/../api/controller/paymentController.php';
                    $controller = new APIPaymentController();
                    $controller->paymentWebhook();
                    break;

                    //Webhook for mollie payment link. Open for everyone
                case "payment/link":
                    require_once __DIR__ . '/../api/controller/paymentController.php';
                    $controller = new APIPaymentController();
                    $controller->paymentLinkWebhook();
                    break;

                    /*----------------------POST cart routes-----------------------------*/


                    //Add ticket to cart. Open for everyone
                case "cart/ticket":
                    require_once __DIR__ . '/../api/controller/cartController.php';
                    $controller = new APICartController();
                    $controller->addToCart(isset($params["id"]) ? $params["id"] : null, isset($params["token"]) ? $params["token"] : null);
                    break;

                default:
                    http_response_code(404);
                    break;
            }
            break;
        case 'PUT':
            switch ($uri) {

                    /*----------------------PUT account routes-----------------------------*/
                    //edit account only for logged in
                case "account":
                    (new Middleware())->loggedInOnly();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->updateAccount($params["id"]);
                    break;
                    //set account active, for admin
                case "account/active":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->setAccountActive($params["id"]);
                    break;
                    //changing email only for logged in
                case "me/change-email":
                    (new Middleware())->loggedInOnly();
                    session_start();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->updateEmailCustomer();
                    break;
                    //change password only for logged in
                case "me/change-password":
                    (new Middleware())->loggedInOnly();
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
                    //delete account for admin only
                case "account":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/accountController.php';
                    $controller = new APIAccountController();
                    $controller->deleteAccount($params["id"]);
                    break;

                    /*----------------------DELETE event routes-----------------------------*/
                    //delete event for admin only
                case "event/event-item":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->deleteEventItem($params['id']);
                    break;
                    //delete event item slot for admin only
                case "event/event-item/slot":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->deleteEventItemSlot($params['id']);
                    break;
                    //delete event item slot ticket for admin only
                case "event/event-item/slot/ticket":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/eventController.php';
                    $controller = new APIEventController();
                    $controller->deleteEventItemSlotTicket($params['id']);
                    break;

                    /*----------------------DELETE information pages routes-----------------------------*/

                    //Delete information page. Admin only
                case "information-page":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    $controller->deleteInformationPage(isset($params["id"]) ? $params["id"] : null);
                    break;

                    //Delete information section from page. Admin only
                case "information-page/information-section":
                    (new Middleware())->adminOnly();
                    require_once __DIR__ . '/../api/controller/informationPageController.php';
                    $controller = new APIInformationPageController();
                    $controller->deleteInformationSection(isset($params["id"]) ? $params["id"] : null);
                    break;

                    /*----------------------DELETE cart routes-----------------------------*/

                    //Delete ticket from cart. Open for everyone
                case "cart/ticket":
                    require_once __DIR__ . '/../api/controller/cartController.php';
                    $controller = new APICartController();
                    $controller->removeFromCart(isset($params["id"]) ? $params["id"] : null, isset($params["token"]) ? $params["token"] : null);
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
