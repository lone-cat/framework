<?php

use LoneCat\Framework\HTTP\Factories\ResponseFactory;
use LoneCat\Framework\HTTP\Factories\ServerRequestFactory;
use LoneCat\Framework\HTTP\Factories\URIFactory;
use LoneCat\Framework\HTTP\Resolvers\ControllerResolver;
use LoneCat\Framework\HTTP\Resolvers\MiddlewareResolver;
use LoneCat\PSR15\MiddlewareResolverInterface;
use LoneCat\Router\RequestHandlerResolverInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

// CONTAINER
// Aliases
$container->setAlias(MiddlewareResolverInterface::class, MiddlewareResolver::class);

$container->setAlias(RequestHandlerResolverInterface::class, ControllerResolver::class);

$container->setAlias(ResponseFactoryInterface::class, ResponseFactory::class);

$container->setAlias(ServerRequestFactoryInterface::class, ServerRequestFactory::class);

$container->setAlias(UriFactoryInterface::class, URIFactory::class);

// Definitions