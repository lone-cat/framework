<?php

namespace LoneCat\Framework\HTTP;

use LoneCat\Framework\Exceptions\ExceptionManager;
use Psr\Container\ContainerInterface;

abstract class Bootstrap
{
    public static function init(ContainerInterface $container) {
        ExceptionManager::init();

        require dirname(__DIR__) . '/Config/Container.php';
        require __DIR__ . '/Config/Container.php';

        require dirname(__DIR__) . '/Services/functions.php';
    }


}