<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/core/Router.php';

use app\core\Router;
use app\controllers\ContactController;

$router = new Router();

$router->add('GET', '/contact', 'ContactController@index');
$router->add('POST', '/contact', 'ContactController@handleContact');

$router->dispatch();
