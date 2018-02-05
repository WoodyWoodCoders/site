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

// var_dump(hash("sha256", "03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4"));

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
// && is_a($_SESSION['user'], "App/UserBundle/Entity/User")
&& !empty($_SESSION['user']->getToken())) {
// && method_exists($_SESSION['user'], 'getToken')
// && !empty($_SESSION['user']->getToken())) {
    $userLogged = true;
    $user = $_SESSION['user'];
    // var_dump($user);
}


$needUserLogged = $controller === "UserController"
                && ($action == "loginAction" || $action == "registerAction")
                ? false
                : true;

// var_dump($page === "UserController" && $action == "loginAction");

if(isset($routeur[$controller]) && class_exists($routeur[$controller]) && method_exists($routeur[$controller], $action)) {
    $controller = new $routeur[$controller]($needUserLogged);

    $action = $controller->$action();
}


// var_dump(
//     $controller->rest(
//         "Wood/rest.php",
//         array(
//             0, 1, 2, 3, 4, 5
//         ),
//         "GET"
//     )
// );
