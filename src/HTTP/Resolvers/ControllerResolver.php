<?php

namespace LoneCat\Framework\HTTP\Resolvers;

use LoneCat\Framework\HTTP\Controllers\Controller;
use LoneCat\Framework\TemplateEngine\Renderer;
use LoneCat\Router\RequestHandlerResolverInterface;

class ControllerResolver
    extends ResolverPSR15Base
    implements RequestHandlerResolverInterface
{

    protected const IMITATION_CLASS = ControllerImitation::class;
    protected const IMITATION_METHOD = 'handle';

    public function resolve($controller_id): Controller
    {
        return $this->getResolvedResultOrNull($controller_id);
    }

    protected function createImitationFromCallable(callable $callable): Controller {
        $imitaion_class_name = self::IMITATION_CLASS;
        $controller = new $imitaion_class_name($this->container->get(Renderer::class));
        $controller->setContainer($this->container);
        $controller->setHandler($this->checkCallableSignature($callable));

        return $controller;
    }


}