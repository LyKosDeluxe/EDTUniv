<?php
session_start();
require '../vendor/autoload.php';

use app\core\Controllers;
use app\core\Router;
use app\stockage\CookieStockage;

date_default_timezone_set('Europe/Paris');

$controllers = new Controllers();
$router = new AltoRouter();

\app\service\FlashService::fetch();
\app\service\FlashService::removeFlash();
try {
    $router->map('GET', '/', function () use ($controllers) {echo $controllers->getControllers()[Controllers::SECURITY_CONTROLLER]->main();}, 'home');
    $router->map('POST', '/', function () use ($controllers) {echo $controllers->getControllers()[Controllers::SECURITY_CONTROLLER]->login();}, 'login');
    $router->map('GET', '/logout', function () use ($controllers){ echo $controllers->getControllers()[Controllers::SECURITY_CONTROLLER]->logout();}, 'logout');
    $router->map('GET', '/edt/today', function () use ($controllers) {echo $controllers->getControllers()[Controllers::TIMETABLE_CONTROLLER]->today();}, 'today');
    $router->map('GET', '/edt', function () use ($controllers) {echo $controllers->getControllers()[Controllers::TIMETABLE_CONTROLLER]->main();}, 'edt');
    $router->map('GET', '/pwa', function () use ($controllers) {
        CookieStockage::basicSet('pwa', true);
        header('Location: /');
    }, 'pwa');
} catch (Exception $e) {
    var_dump($e->getMessage());
}


Router::start($router->match());
