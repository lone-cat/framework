<?php

namespace app\HTTP\Middleware;

use LoneCat\Framework\HTTP\Middleware\Middleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TimeCounter
    extends Middleware
{
    protected float $start;

    protected function processRequest(ServerRequestInterface $request): ServerRequestInterface
    {
        $this->start = microtime(true);
        return $request;
    }

    protected function processResponse(ResponseInterface $response): ResponseInterface
    {
        return $response->withAddedHeader('X-Execution-Time', ((int) ((microtime(true) - $this->start) * 1000)) . ' ms');
    }

}