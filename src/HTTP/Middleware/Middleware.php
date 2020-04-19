<?php

namespace LoneCat\Framework\HTTP\Middleware;

use LoneCat\PSR11\ContainerAware\ContainerAwareTrait;
use LoneCat\PSR11\ContainerAware\ContanerAwareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class Middleware
    implements MiddlewareInterface,
    ContanerAwareInterface
{
    use ContainerAwareTrait;

    public function process(ServerRequestInterface $request,
                            RequestHandlerInterface $handler): ResponseInterface
    {
        $request = $this->processRequest($request);
        $response = $handler->handle($request);
        return $this->processResponse($response);
    }

    protected function processRequest(ServerRequestInterface $request): ServerRequestInterface
    {
        return $request;
    }

    protected function processResponse(ResponseInterface $response): ResponseInterface
    {
        return $response;
    }
}