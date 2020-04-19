<?php

namespace app\HTTP\Middleware;

use app\HTTP\Controllers\DefaultController;
use LoneCat\Framework\HTTP\Middleware\Middleware;
use LoneCat\Router\Router;
use Psr\Http\Message\ServerRequestInterface;

class Auth extends Middleware
{

    public function processRequest(ServerRequestInterface $request): ServerRequestInterface
    {
        $router = $this->container->get(Router::class);
        $router->addGet('main', '/', DefaultController::class)->middleware(TimeCounter::class);
        $router->addGet('main2', '/a', [DefaultController::class => 'test']);

        return $request;
    }


}