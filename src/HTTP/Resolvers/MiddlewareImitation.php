<?php

namespace LoneCat\Framework\HTTP\Resolvers;

use Closure;
use LoneCat\Framework\HTTP\Middleware\Middleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareImitation
    extends Middleware
{
    private $handler;

    public function process(ServerRequestInterface $request,
                            RequestHandlerInterface $handler): ResponseInterface
    {
        return ($this->handler)($request, $handler);
    }

    public function setHandler(callable $handler) {
        if ($handler instanceof Closure) {
            $handler = $handler->bindTo($this, $this);
        }

        $this->handler = $handler;
    }

}