<?php

/**
 * Rotas do sistema, da API e do painel de administração
 * PHP version 8.3.12
 *
 * @category Routes
 * @package  Root
 * @author   Luiz Amichi <eu@luizamichi.com.br>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/luizamichi/hcode-store
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "env.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "functions.php";


session_name(getenv("PHP_SESSION_NAME") ?: "Ecommerce");
session_start();


use Amichi\Controller\AddressController;
use Amichi\Controller\CartController;
use Amichi\Controller\CategoryController;
use Amichi\Controller\CityController;
use Amichi\Controller\ContactController;
use Amichi\Controller\CountryController;
use Amichi\Controller\MailController;
use Amichi\Controller\OrderController;
use Amichi\Controller\OrderStatusController;
use Amichi\Controller\OtherController;
use Amichi\Controller\ProductController;
use Amichi\Controller\StateController;
use Amichi\Controller\StreetTypeController;
use Amichi\Controller\SubtopicController;
use Amichi\Controller\TopicController;
use Amichi\Controller\TopicTypeController;
use Amichi\Controller\UserController;
use Amichi\Controller\WishlistController;

use Amichi\Middleware\AuthorizationMiddleware;
use Amichi\Middleware\CorsMiddleware;
use Amichi\Middleware\EnvironmentMiddleware;
use Amichi\Middleware\JsonMiddleware;
use Amichi\Middleware\LoggedInMiddleware;

use Amichi\View\AddressView;
use Amichi\View\CartView;
use Amichi\View\CategoryView;
use Amichi\View\CityView;
use Amichi\View\ContactView;
use Amichi\View\CountryView;
use Amichi\View\MailView;
use Amichi\View\OrderStatusView;
use Amichi\View\OrderView;
use Amichi\View\OtherView;
use Amichi\View\ProductView;
use Amichi\View\StateView;
use Amichi\View\StreetTypeView;
use Amichi\View\SubtopicView;
use Amichi\View\TopicTypeView;
use Amichi\View\TopicView;
use Amichi\View\UserView;
use Amichi\View\WishlistView;

use Slim\Factory\AppFactory;


$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();

$debug = getenv("PHP_DEBUG") === "true";
$errorMiddleware = $app->addErrorMiddleware($debug, $debug, $debug);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType("application/json");


if ($debug) {
    ini_set("display_errors", true);
    ini_set("display_startup_errors", true);
    error_reporting(E_ALL);
}


$app->group(
    "/api",
    function ($app) {
        $app->post("/login", UserController::class . ":login");
        $app->get("/logout", UserController::class . ":logout")->add([LoggedInMiddleware::class, "user"]);
        $app->get("/status", OtherController::class . ":status");
        $app->post("/sqlquery", OtherController::class . ":sqlQuery")->add([LoggedInMiddleware::class, "admin"]);
        $app->post("/phpeval", OtherController::class . ":phpEval")->add([LoggedInMiddleware::class, "admin"]);
        $app->get("/session", OtherController::class . ":phpSession")->add([LoggedInMiddleware::class, "admin"]);
        $app->post("/forgot", OtherController::class . ":forgot");
        $app->post("/resetpassword", OtherController::class . ":resetPassword");
        $app->put("/changepassword", OtherController::class . ":changePassword")->add([LoggedInMiddleware::class, "user"]);
        $app->get("/zipcode/{zipCode}", OtherController::class . ":zipCode");
    }
)->add(CorsMiddleware::class)->add(JsonMiddleware::class);


$app->group(
    "/api/country",
    function ($app) {
        $app->get("", CountryController::class . ":getAll");
        $app->get("/{idCountry}", CountryController::class . ":get");
        $app->get("/{idCountry}/state", StateController::class . ":getByCountry");
        $app->post("", CountryController::class . ":post")->add([LoggedInMiddleware::class, "admin"]);
        $app->put("/{idCountry}", CountryController::class . ":put")->add([LoggedInMiddleware::class, "admin"]);
        $app->delete("/{idCountry}", CountryController::class . ":delete")->add([LoggedInMiddleware::class, "admin"]);
    }
)->add(CorsMiddleware::class)->add(JsonMiddleware::class);


$app->group(
    "/api/state",
    function ($app) {
        $app->get("", StateController::class . ":getAll");
        $app->get("/{idState}", StateController::class . ":get");
        $app->get("/{idState}/city", CityController::class . ":getByState");
        $app->post("", StateController::class . ":post")->add([LoggedInMiddleware::class, "admin"]);
        $app->put("/{idState}", StateController::class . ":put")->add([LoggedInMiddleware::class, "admin"]);
        $app->delete("/{idState}", StateController::class . ":delete")->add([LoggedInMiddleware::class, "admin"]);
    }
)->add(CorsMiddleware::class)->add(JsonMiddleware::class);


$app->group(
    "/api/city",
    function ($app) {
        $app->get("", CityController::class . ":getAll");
        $app->get("/{idCity}", CityController::class . ":get");
        $app->post("", CityController::class . ":post")->add([LoggedInMiddleware::class, "admin"]);
        $app->put("/{idCity}", CityController::class . ":put")->add([LoggedInMiddleware::class, "admin"]);
        $app->delete("/{idCity}", CityController::class . ":delete")->add([LoggedInMiddleware::class, "admin"]);
    }
)->add(CorsMiddleware::class)->add(JsonMiddleware::class);


$app->group(
    "/api/streettype",
    function ($app) {
        $app->get("", StreetTypeController::class . ":getAll");
        $app->get("/{idStreetType}", StreetTypeController::class . ":get");
        $app->post("", StreetTypeController::class . ":post")->add([LoggedInMiddleware::class, "admin"]);
        $app->put("/{idStreetType}", StreetTypeController::class . ":put")->add([LoggedInMiddleware::class, "admin"]);
        $app->delete("/{idStreetType}", StreetTypeController::class . ":delete")->add([LoggedInMiddleware::class, "admin"]);
    }
)->add(CorsMiddleware::class)->add(JsonMiddleware::class);


$app->group(
    "/api/contact",
    function ($app) {
        $app->get("", ContactController::class . ":getAll")->add([LoggedInMiddleware::class, "admin"]);
        $app->get("/{idContact}", ContactController::class . ":get")->add([LoggedInMiddleware::class, "admin"]);
        $app->post("", ContactController::class . ":post");
        $app->put("/{idContact}", ContactController::class . ":put")->add([LoggedInMiddleware::class, "admin"]);
        $app->delete("/{idContact}", ContactController::class . ":delete")->add([LoggedInMiddleware::class, "admin"]);
    }
)->add(CorsMiddleware::class)->add(JsonMiddleware::class);


$app->group(
    "/api/user",
    function ($app) {
        $app->get("", UserController::class . ":getAll")->add([LoggedInMiddleware::class, "admin"]);
        $app->get("/{idUser}", UserController::class . ":get")->add([LoggedInMiddleware::class, "admin"]);
        $app->post("", UserController::class . ":post");
        $app->put("/{idUser}", UserController::class . ":put")->add([LoggedInMiddleware::class, "user"]);
        $app->delete("/{idUser}", UserController::class . ":delete")->add([LoggedInMiddleware::class, "admin"]);

        $app->get("/{idUser}/address", UserController::class . ":getAddress")->add([LoggedInMiddleware::class, "user"]);
        $app->get("/{idUser}/order", OrderController::class . ":getByUser")->add([LoggedInMiddleware::class, "user"]);
        $app->get("/{idUser}/product", WishlistController::class . ":getByUser")->add([LoggedInMiddleware::class, "user"]);
        $app->post("/{idUser}/product/{idProduct}", WishlistController::class . ":post")->add([LoggedInMiddleware::class, "user"]);
        $app->delete("/{idUser}/product/{idProduct}", WishlistController::class . ":delete")->add([LoggedInMiddleware::class, "user"]);
        $app->get("/{idUser}/log", UserController::class . ":getLogs")->add([LoggedInMiddleware::class, "user"]);
        $app->get("/{idUser}/passwordrecovery", UserController::class . ":getPasswordRecoveries")->add([LoggedInMiddleware::class, "user"]);
        $app->put("/{idUser}/password", UserController::class . ":updatePassword")->add([LoggedInMiddleware::class, "admin"]);
    }
)->add(CorsMiddleware::class)->add(JsonMiddleware::class);


$app->group(
    "/api/mail",
    function ($app) {
        $app->get("", MailController::class . ":getAll");
        $app->get("/{idMail}", MailController::class . ":get");
        $app->post("", MailController::class . ":post");
        $app->put("/{idMail}", MailController::class . ":put");
        $app->delete("/{idMail}", MailController::class . ":delete");
    }
)->add(CorsMiddleware::class)->add(JsonMiddleware::class)->add([LoggedInMiddleware::class, "admin"]);


$app->group(
    "/api/address",
    function ($app) {
        $app->get("", AddressController::class . ":getAll")->add([LoggedInMiddleware::class, "admin"]);
        $app->get("/{idAddress}", AddressController::class . ":get")->add([LoggedInMiddleware::class, "admin"]);
        $app->post("", AddressController::class . ":post")->add([LoggedInMiddleware::class, "user"]);
        $app->put("/{idAddress}", AddressController::class . ":put")->add([LoggedInMiddleware::class, "user"]);
        $app->delete("/{idAddress}", AddressController::class . ":delete")->add([LoggedInMiddleware::class, "admin"]);
    }
)->add(CorsMiddleware::class)->add(JsonMiddleware::class);


$app->group(
    "/api/product",
    function ($app) {
        $app->get("", ProductController::class . ":getAll");
        $app->get("/{idProduct}", ProductController::class . ":get");
        $app->post("", ProductController::class . ":post")->add([LoggedInMiddleware::class, "admin"]);
        $app->put("/{idProduct}", ProductController::class . ":put")->add([LoggedInMiddleware::class, "admin"]);
        $app->delete("/{idProduct}", ProductController::class . ":delete")->add([LoggedInMiddleware::class, "admin"]);
    }
)->add(CorsMiddleware::class)->add(JsonMiddleware::class);


$app->group(
    "/api/category",
    function ($app) {
        $app->get("", CategoryController::class . ":getAll");
        $app->get("/{idCategory}", CategoryController::class . ":get");
        $app->get("/{idCategory}/product", CategoryController::class . ":getProducts");
        $app->post("", CategoryController::class . ":post")->add([LoggedInMiddleware::class, "admin"]);
        $app->post("/{idCategory}/product/{idProduct}", CategoryController::class . ":postProduct")->add([LoggedInMiddleware::class, "admin"]);
        $app->put("/{idCategory}", CategoryController::class . ":put")->add([LoggedInMiddleware::class, "admin"]);
        $app->delete("/{idCategory}", CategoryController::class . ":delete")->add([LoggedInMiddleware::class, "admin"]);
        $app->delete("/{idCategory}/product/{idProduct}", CategoryController::class . ":deleteProduct")->add([LoggedInMiddleware::class, "admin"]);
    }
)->add(CorsMiddleware::class)->add(JsonMiddleware::class);


$app->group(
    "/api/cart",
    function ($app) {
        $app->get("", CartController::class . ":getAll")->add([LoggedInMiddleware::class, "admin"]);
        $app->get("/{idCart}", CartController::class . ":get")->add([LoggedInMiddleware::class, "user"]);
        $app->get("/{idCart}/product", CartController::class . ":getProducts")->add([LoggedInMiddleware::class, "user"]);
        $app->post("", CartController::class . ":post");
        $app->post("/{idCart}/product/{idProduct}", CartController::class . ":postProduct");
        $app->put("/{idCart}", CartController::class . ":put")->add([LoggedInMiddleware::class, "user"]);
        $app->delete("/{idCart}", CartController::class . ":delete")->add([LoggedInMiddleware::class, "admin"]);
        $app->delete("/{idCart}/product/{idProduct}", CartController::class . ":deleteProduct");
    }
)->add(CorsMiddleware::class)->add(JsonMiddleware::class);


$app->group(
    "/api/order/status",
    function ($app) {
        $app->get("", OrderStatusController::class . ":getAll");
        $app->get("/{idStatus}", OrderStatusController::class . ":get");
        $app->post("", OrderStatusController::class . ":post")->add([LoggedInMiddleware::class, "admin"]);
        $app->put("/{idStatus}", OrderStatusController::class . ":put")->add([LoggedInMiddleware::class, "admin"]);
        $app->delete("/{idStatus}", OrderStatusController::class . ":delete")->add([LoggedInMiddleware::class, "admin"]);
    }
)->add(CorsMiddleware::class)->add(JsonMiddleware::class);


$app->group(
    "/api/order",
    function ($app) {
        $app->get("", OrderController::class . ":getAll")->add([LoggedInMiddleware::class, "admin"])->add(JsonMiddleware::class);
        $app->get("/{idOrder}", OrderController::class . ":get")->add([LoggedInMiddleware::class, "admin"])->add(JsonMiddleware::class);
        $app->get("/{idOrder}/bankpaymentslip", OrderController::class . ":getBankPaymentSlip")->add([LoggedInMiddleware::class, "user"])->add(EnvironmentMiddleware::class);
        $app->post("", OrderController::class . ":post")->add([LoggedInMiddleware::class, "admin"])->add(JsonMiddleware::class);
        $app->put("/{idOrder}", OrderController::class . ":put")->add([LoggedInMiddleware::class, "admin"])->add(JsonMiddleware::class);
        $app->delete("/{idOrder}", OrderController::class . ":delete")->add([LoggedInMiddleware::class, "admin"])->add(JsonMiddleware::class);
    }
)->add(CorsMiddleware::class);


$app->group(
    "/api/topic/type",
    function ($app) {
        $app->get("", TopicTypeController::class . ":getAll");
        $app->get("/{idType}", TopicTypeController::class . ":get");
        $app->post("", TopicTypeController::class . ":post")->add([LoggedInMiddleware::class, "admin"]);
        $app->put("/{idType}", TopicTypeController::class . ":put")->add([LoggedInMiddleware::class, "admin"]);
        $app->delete("/{idType}", TopicTypeController::class . ":delete")->add([LoggedInMiddleware::class, "admin"]);
    }
)->add(CorsMiddleware::class)->add(JsonMiddleware::class);


$app->group(
    "/api/topic",
    function ($app) {
        $app->get("", TopicController::class . ":getAll");
        $app->get("/{idTopic}", TopicController::class . ":get");
        $app->post("", TopicController::class . ":post")->add([LoggedInMiddleware::class, "admin"]);
        $app->put("/{idTopic}", TopicController::class . ":put")->add([LoggedInMiddleware::class, "admin"]);
        $app->delete("/{idTopic}", TopicController::class . ":delete")->add([LoggedInMiddleware::class, "admin"]);
    }
)->add(CorsMiddleware::class)->add(JsonMiddleware::class);


$app->group(
    "/api/subtopic",
    function ($app) {
        $app->get("", SubtopicController::class . ":getAll");
        $app->get("/{idSubtopic}", SubtopicController::class . ":get");
        $app->post("", SubtopicController::class . ":post")->add([LoggedInMiddleware::class, "admin"]);
        $app->put("/{idSubtopic}", SubtopicController::class . ":put")->add([LoggedInMiddleware::class, "admin"]);
        $app->delete("/{idSubtopic}", SubtopicController::class . ":delete")->add([LoggedInMiddleware::class, "admin"]);
    }
)->add(CorsMiddleware::class)->add(JsonMiddleware::class);


$app->group(
    "/admin",
    function ($app) {
        $app->get("/login", UserView::class . ":login");
        $app->get("/logout", UserView::class . ":logout");
        $app->get("/register", UserView::class . ":register");
        $app->get("/forgot", OtherView::class . ":forgot")->add([LoggedInMiddleware::class, "notLogged"]);
        $app->get("/resetpassword", OtherView::class . ":resetPassword");
        $app->get("/changepassword", OtherView::class . ":changePassword")->add([AuthorizationMiddleware::class, "isUser"]);
    }
)->add(EnvironmentMiddleware::class);


$app->group(
    "/admin",
    function ($app) {
        $app->get("", OtherView::class . ":administrativePanel");
        $app->get("/configurations", OtherView::class . ":configurations");

        $app->get("/countries", CountryView::class . ":getAll");
        $app->get("/states", StateView::class . ":getAll");
        $app->get("/cities", CityView::class . ":getAll");
        $app->get("/streettypes", StreetTypeView::class . ":getAll");

        $app->get("/contacts", ContactView::class . ":getAll");
        $app->get("/mails", MailView::class . ":getAll");

        $app->get("/users", UserView::class . ":getAll");
        $app->get("/users/create", UserView::class . ":create");
        $app->get("/users/{idUser}", UserView::class . ":update");
        $app->get("/users/{idUser}/logs", UserView::class . ":getLogs");

        $app->get("/addresses", AddressView::class . ":getAll");
        $app->get("/addresses/create", AddressView::class . ":create");
        $app->get("/addresses/{idAddress}", AddressView::class . ":update");

        $app->get("/products", ProductView::class . ":getAll");
        $app->get("/products/create", ProductView::class . ":create");
        $app->get("/products/{idProduct}", ProductView::class . ":update");

        $app->get("/categories", CategoryView::class . ":getAll");
        $app->get("/categories/create", CategoryView::class . ":create");
        $app->get("/categories/{idCategory}", CategoryView::class . ":update");
        $app->get("/categories/{idCategory}/products", CategoryView::class . ":getProducts");

        $app->get("/carts", CartView::class . ":getAll");
        $app->get("/carts/{idCart}/products", CartView::class . ":getProducts");

        $app->get("/orders", OrderView::class . ":getAll");
        $app->get("/orders/status", OrderStatusView::class . ":getAll");
        $app->get("/orders/{idOrder}", OrderView::class . ":view");

        $app->get("/topics", TopicView::class . ":getAll");
        $app->get("/topics/types", TopicTypeView::class . ":getAll");
        $app->get("/topics/create", TopicView::class . ":create");
        $app->get("/topics/{idTopic}", TopicView::class . ":update");

        $app->get("/subtopics", SubtopicView::class . ":getAll");
        $app->get("/subtopics/create", SubtopicView::class . ":create");
        $app->get("/subtopics/{idSubtopic}", SubtopicView::class . ":update");
    }
)->add(EnvironmentMiddleware::class)->add([AuthorizationMiddleware::class, "isAdmin"]);


$app->group(
    "",
    function ($app) {
        $app->get("/", OtherView::class . ":mainPage");
        $app->get("/cart", CartView::class . ":webView");
        $app->get("/categories", CategoryView::class . ":webList");
        $app->get("/categories/{slugCategory}", CategoryView::class . ":webView");
        $app->get("/checkout", OrderView::class . ":webView")->add([AuthorizationMiddleware::class, "isUser"]);
        $app->get("/contact", ContactView::class . ":webView");
        $app->get("/orders", OrderView::class . ":webList")->add([AuthorizationMiddleware::class, "isUser"]);
        $app->get("/orders/{codeOrder}/pagseguro", OrderView::class . ":pagSeguro")->add([AuthorizationMiddleware::class, "isUser"]);
        $app->get("/orders/{codeOrder}/paypal", OrderView::class . ":payPal")->add([AuthorizationMiddleware::class, "isUser"]);
        $app->get("/posts", TopicTypeView::class . ":webView");
        $app->get("/posts/{slugTopicType}", TopicView::class . ":webView");
        $app->get("/profile", UserView::class . ":webView")->add([AuthorizationMiddleware::class, "isUser"]);
        $app->get("/products", ProductView::class . ":webList");
        $app->get("/products/{slugProduct}", ProductView::class . ":webView");
        $app->get("/wishlist", WishlistView::class . ":webView")->add([AuthorizationMiddleware::class, "isUser"]);
    }
)->add(EnvironmentMiddleware::class);


$app->get("/api/{route}", OtherController::class . ":error")->add(JsonMiddleware::class);
$app->get("/{route}", OtherView::class . ":error")->add(EnvironmentMiddleware::class);
$app->get("/admin/{route}", OtherView::class . ":administrativePanel")->add(EnvironmentMiddleware::class)->add([AuthorizationMiddleware::class, "isAdmin"]);


$app->run();
