<?php

use LoneCat\Framework\HTTP\Application;
use LoneCat\Framework\HTTP\Bootstrap;
use LoneCat\PSR11\Container;
use Psr\Http\Message\ServerRequestFactoryInterface;

// Require path setup
$root_path = dirname(__DIR__);
chdir($root_path);
set_include_path($root_path);

// Autoloader
require 'vendor/autoload.php';

Bootstrap::initFunctions();

// Container initialization
$container = Container::instance();
Bootstrap::initContainer($container);
require 'config/Container.php';

$app = $container->get(Application::class);

// Middleware initialization
require 'config/Middleware.php';

// Routes initialization
require 'config/Routes.php';

// Server request generation
$request = $container->get(ServerRequestFactoryInterface::class)->generateServerRequestFromGlobals();