<?php

namespace LoneCat\Framework\HTTP\Factories;

use LoneCat\PSR7\HTTP\URI\URI;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

class URIFactory
    implements UriFactoryInterface
{

    public function createUri(string $uri = ''): UriInterface
    {
        return new URI($uri);
    }

}