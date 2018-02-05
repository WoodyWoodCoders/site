<?php
define('DS', DIRECTORY_SEPARATOR); // meilleur portabilitÃ© sur les diffÃ©rents systeme.
define('ROOT', dirname(__FILE__).DS);
// localhost
 define('GLOBAL_PATH', '/Wood/');
 define('GLOBAL_DOMAIN', 'localhost');
 define('GLOBAL_URL', "http://" . GLOBAL_DOMAIN . GLOBAL_PATH);
 define('GLOBAL_WEB_SOCKET', '82.64.32.99:8084/');
 // define('GLOBAL_WEB_SOCKET', 'localhost:8084/');

// use App\UserBundle\Entity\User;

require 'routeur.php';

require 'Autoloader.php';
Autoloader::register();


session_start();

$dateNow = new DateTime("now");

$page = isset($_GET["p"])
        ? strtolower($_GET["p"])
        : "Client";
$action = isset($_GET["a"])
        ? strtolower($_GET["a"])
        : "index";


// $controller = "App\UserBundle\Controller\\" . ucfirst($page) . "Controller";
$controller = ucfirst($page) . "Controller";
$action = $action . "Action";
// var_dump(
//     $_POST,
//     $controller,
//     $action,
//     isset($routeur[$controller]),
//     $routeur[$controller],
//     class_exists($routeur[$controller]),
//     method_exists($routeur[$controller], $action)
// );

$userLogged = false;
if(isset($_SESSION['user'])
&& !empty($_SESSION['user']->getToken())) {
    $userLogged = true;
    $user = $_SESSION['user'];
    // var_dump($user);
}


$needUserLogged = $controller === "UserController"
                && ($action == "loginAction" || $action == "registerAction")
                ? false
                : true;

if(isset($routeur[$controller]) && class_exists($routeur[$controller]) && method_exists($routeur[$controller], $action)) {
    $controller = new $routeur[$controller]($needUserLogged);

    $action = $controller->$action();
}
