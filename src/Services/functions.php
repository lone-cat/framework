<?php

use LoneCat\PSR11\Container;
use LoneCat\Router\Router;

// global
function route(string $route_name, array $vars = []) {
    $router = Container::instance()->get(Router::class);

    return $router->generateUrl($route_name, $vars);
}
