<?php
require_once __DIR__ . '/../middleware/middleware.php';

function handleRoutes($uri, $requestMethod, $content)
{
    if ($requestMethod != "GET") http_response_code(404);

    // ASSESSMENT Show content pages

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
        case 'events/music/jazz':
            require __DIR__ . '/../controller/homeController.php';
            session_start();
            $controller = new HomeController();
            $controller->jazz();
            break;
        case 'events/music/dance':
            require __DIR__ . '/../controller/homeController.php';
            session_start();
            $controller = new HomeController();
            $controller->dance();
            break;
        case 'festival':
            require __DIR__ . '/../controller/homeController.php';
            session_start();
            $controller = new HomeController();
            $controller->festival();
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
        case 'dashboard/accounts/add':
            require __DIR__ . '/../controller/dashboardController.php';
            session_start();
            $controller = new DashboardController();
            $controller->addAccount();
            break;
        case 'dashboard/accounts/edit':
            require __DIR__ . '/../controller/dashboardController.php';
            session_start();
            $controller = new DashboardController();
            $controller->editAccount();
            break;
        case 'dashboard/events':
            require __DIR__ . '/../controller/dashboardController.php';
            session_start();
            $controller = new DashboardController();
            $controller->events();
            break;
        case 'dashboard/events/event-items':
            require __DIR__ . '/../controller/dashboardController.php';
            session_start();
            $controller = new DashboardController();
            $controller->viewEventItems();
            break;
        case 'dashboard/events/event-item/edit':
            require __DIR__ . '/../controller/dashboardController.php';
            session_start();
            $controller = new DashboardController();
            $controller->editEventItems();
            break;
        case 'dashboard/events/event-items/slots':
            require __DIR__ . '/../controller/dashboardController.php';
            session_start();
            $controller = new DashboardController();
            $controller->eventItemSlots();
            break;
        case 'dashboard/events/event-items/tickets':
            require __DIR__ . '/../controller/dashboardController.php';
            session_start();
            $controller = new DashboardController();
            $controller->eventItemTickets();
            break;
        case 'dashboard/events/event-items/ticket/edit':
            require __DIR__ . '/../controller/dashboardController.php';
            session_start();
            $controller = new DashboardController();
            $controller->editEventItemTicket();
            break;
        case 'dashboard/events/event-items/ticket/add':
            require __DIR__ . '/../controller/dashboardController.php';
            session_start();
            $controller = new DashboardController();
            $controller->addEventItemTicket();
            break;
        case 'dashboard/events/event-items/slot/edit':
            require __DIR__ . '/../controller/dashboardController.php';
            session_start();
            $controller = new DashboardController();
            $controller->editEventItemSlot();
            break;
        case 'dashboard/events/event-items/slot/add':
            require __DIR__ . '/../controller/dashboardController.php';
            session_start();
            $controller = new DashboardController();
            $controller->addEventItemSlot();
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
        case 'dashboard/orders':
            require __DIR__ . '/../controller/dashboardController.php';
            session_start();
            $controller = new DashboardController();
            $controller->allOrders();
            break;
        case 'dashboard/order/edit':
            require __DIR__ . '/../controller/dashboardController.php';
            session_start();
            $controller = new DashboardController();
            $controller->editOrder();
            break;

            /*----------------------Account routes-----------------------------*/

        case 'login':
            require __DIR__ . '/../controller/accountController.php';
            session_start();
            $controller = new AccountController();
            $controller->login();
            break;
        case 'login/reset/password':
            session_start();
            (new Middleware())->validToken();
            require __DIR__ . '/../controller/accountController.php';
            $controller = new AccountController();
            $controller->resetPassword();
            break;
        case 'login/reset/email':
            require __DIR__ . '/../controller/accountController.php';
            session_start();
            $controller = new AccountController();
            $controller->resetEmail();
            break;
        case 'login/reset/sendResetLink':
            require __DIR__ . '/../controller/accountController.php';
            session_start();
            $controller = new AccountController();
            $controller->sendResetLink();
            break;
        case 'sign-up':
            require __DIR__ . '/../controller/accountController.php';
            session_start();
            $controller = new AccountController();
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

        case "checkout":
            require __DIR__ . '/../controller/cartController.php';
            session_start();
            $controller = new CartController();
            $controller->checkout();
            break;

        case "cart/shared":
            require __DIR__ . '/../controller/cartController.php';
            session_start();
            $controller = new CartController();
            $controller->shared();
            break;

        case "checkout/shared":
            require __DIR__ . '/../controller/cartController.php';
            session_start();
            $controller = new CartController();
            $controller->checkoutShared();
            break;

            /*----------------------Order routes-----------------------------*/

        case "order":
            require __DIR__ . '/../controller/orderController.php';
            session_start();
            $controller = new OrderController();
            $controller->index();
            break;


        default:
            http_response_code(404);
            break;
    }
}
