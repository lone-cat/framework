<?php

namespace LoneCat\Framework\HTTP;

abstract class Bootstrap
{
    public static function initContainer(\Psr\Container\ContainerInterface $container) {
        require dirname(__DIR__) . '/Config/Container.php';
        require __DIR__ . '/Config/Container.php';
    }

    public static function initFunctions() {
        require dirname(__DIR__) . '/Services/functions.php';
    }

}