<?php
include_once("../vendor/autoload.php");
session_start();
if (($_SERVER['REQUEST_URI'] == "/index.php?page=carrito" || $_SERVER['REQUEST_URI'] == "/index.php" || $_SERVER['REQUEST_URI'] == "/index.php?page=listado")  && (!isset($_SESSION['isLogged']) || !$_SESSION['isLogged'])) {
    header("Location: index.php?page=loginForm");
}
if (isset($_GET['item'])) {
    $_SESSION['carrito'][] = $_GET['item'];
}
$which = $_GET['page'];
$router = new Library\Router();
$lp = new Carrito\Paginas\verListadoProductos();
$carr = new Carrito\Paginas\verCarrito();
$regform = new Carrito\Paginas\verRegistro();
$logform = new Carrito\Paginas\verLogin();
$register = new Carrito\Paginas\register();
$login = new Carrito\Paginas\login();
$eliminar = new Carrito\Paginas\eliminarDelCarrito();
$logout = new Carrito\Paginas\logout();
$router->addRouteOld("carrito", $carr);
$router->addRouteOld("listado", $lp);
$router->addRouteOld("registerForm", $regform);
$router->addRouteOld("loginForm", $logform);
$router->addRouteOld("register", $register);
$router->addRouteOld("login", $login);
$router->addRouteOld("eliminarDelCarrito", $eliminar);
$router->addRouteOld("logout", $logout);

if (isset($which)) {
    $page = $router->matchOld($which);
} else {
    $page = $router->matchOld("listado");
}

$te = new Library\TemplateEngine("../src/templates/index.template");
$nav = new Library\TemplateEngine("../src/templates/navbar.template");
$nav->addVariable("username", $_SESSION['username']);
$te->addVariable("navbar", $nav->render());
$te->addVariable("contenido", $page->mostrar());
echo $te->render();
