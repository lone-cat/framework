<?php

namespace LoneCat\Framework\HTTP\Middleware;

use Exception;
use LoneCat\Framework\HTTP\Controllers\ExceptionControllerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class ExceptionMiddleware
    extends Middleware
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $response = $handler->handle($request);
        } catch (Throwable $e) {
            $controller = $this->container->get(ExceptionControllerInterface::class);
            $response = $controller->handle($request->withAttribute(Exception::class, $e));
        }
        return $response;
    }

}