<?php

namespace LoneCat\Framework\HTTP\Resolvers;

use Closure;
use LoneCat\Framework\HTTP\Controllers\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ControllerImitation
    extends Controller
{
    private $handler;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return ($this->handler)($request);
    }

    public function setHandler(callable $handler) {
        if ($handler instanceof Closure) {
            $handler = $handler->bindTo($this, $this);
        }

        $this->handler = $handler;
    }
}