<?php

use app\HTTP\Controllers\ExceptionController;
use app\HTTP\Factories\AppServerRequestFactory;
use LoneCat\Framework\HTTP\Controllers\ExceptionControllerInterface;
use LoneCat\PSR11\Container;
use LoneCat\PSR7\HTTP\Messages\ServerRequest;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

// CONTAINER
// Aliases
$container->setAlias(ContainerInterface::class, Container::class);

$container->setAlias(ServerRequestFactoryInterface::class, AppServerRequestFactory::class);

$container->setAlias(ServerRequestInterface::class, ServerRequest::class);

$container->setAlias(ExceptionControllerInterface::class, ExceptionController::class);

// Definitions
$container->set(
    ServerRequest::class,
    $container->get(ServerRequestFactoryInterface::class)->generateServerRequestFromGlobals()
);