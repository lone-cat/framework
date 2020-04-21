<?php

use app\HTTP\Controllers\DefaultController;
use LoneCat\Router\Router;

$router = $container->get(Router::class);

$router->addGet('main', '/', DefaultController::class);

$router->addGet('page2', '/page2', [DefaultController::class => 'page2']);