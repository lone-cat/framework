<?php

namespace LoneCat\Framework\HTTP\Middleware;

use LoneCat\Framework\HTTP\Application;
use LoneCat\Router\Result;
use LoneCat\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteMatchMiddleware
    extends Middleware
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        /** @var Router $router */
        $router = $this->container->get(Router::class);

        $result = $router->getMatchingRouteResult($request);

        return $handler->handle($request->withAttribute(Result::class, $result));
    }

}