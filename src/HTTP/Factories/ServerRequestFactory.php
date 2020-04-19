<?php

namespace LoneCat\Framework\HTTP\Factories;

use LoneCat\PSR7\HTTP\Messages\ServerRequest;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class ServerRequestFactory
    implements ServerRequestFactoryInterface
{

    public function createServerRequest(string $method, $uri,
                                        array $serverParams = []): ServerRequestInterface
    {
        return new ServerRequest($method, $uri, $serverParams);
    }

}