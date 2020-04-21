<?php

use app\HTTP\Controllers\ExceptionController;
use app\HTTP\Controllers\PageNotFoundController;
use app\HTTP\Factories\AppServerRequestFactory;
use LoneCat\Framework\HTTP\Controllers\ExceptionControllerInterface;
use LoneCat\PSR11\Container;
use LoneCat\PSR7\HTTP\Messages\ServerRequest;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

// CONTAINER
// Aliases
$container->setAlias(ContainerInterface::class, Container::class);

$container->setAlias(ServerRequestFactoryInterface::class, AppServerRequestFactory::class);

$container->setAlias(ExceptionControllerInterface::class, ExceptionController::class);

$container->setAlias(RequestHandlerInterface::class, PageNotFoundController::class);

// Definitions
