<?php

use app\HTTP\Controllers\PageNotFoundController;
use app\HTTP\Middleware\Auth;
use LoneCat\Framework\HTTP\Application;
use LoneCat\PSR11\Container;
use LoneCat\PSR15\Pipeline;
use LoneCat\PSR7\HTTP\Messages\ServerRequest;

$root_path = dirname(__DIR__);
chdir($root_path);
set_include_path($root_path);

require 'vendor/autoload.php';

$container = Container::instance();

$app = new Application($container->get(PageNotFoundController::class));
$app->setContainer($container);

$container->set(Application::class, $app);

require 'config/Container.php';

$request = $container->get(ServerRequest::class);

$pipeline = $container->get(Pipeline::class);
$pipeline->middleware(Auth::class);