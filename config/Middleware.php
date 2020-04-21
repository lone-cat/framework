<?php

use app\HTTP\Middleware\TimeCounter;
use LoneCat\PSR15\Pipeline;

$pipeline = $container->get(Pipeline::class);

$pipeline->middleware([TimeCounter::class => 'process']);