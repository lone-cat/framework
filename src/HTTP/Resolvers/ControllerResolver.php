<?php

namespace LoneCat\Framework\HTTP\Resolvers;

use LoneCat\Framework\Exceptions\FrameworkException;
use LoneCat\Framework\HTTP\Controllers\Controller;
use LoneCat\TemplateEngine\Renderer;
use LoneCat\Router\RequestHandlerResolverInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ControllerResolver
    extends ResolverPSR15Base
    implements RequestHandlerResolverInterface
{

    protected const IMITATION_CLASS = ControllerImitation::class;
    protected const IMITATION_METHOD = 'handle';

    public function resolve($controller_id): RequestHandlerInterface
    {
        $controller = $this->getResolvedResultOrNull($controller_id);
        if (!$controller instanceof RequestHandlerInterface) {
            throw new FrameworkException('Controller "' . $this->stringifyHandlerId($controller_id) . '" could not be resolved!');
        }
        return $controller;
    }

    protected function createImitationFromCallable(callable $callable): Controller {
        $imitaion_class_name = self::IMITATION_CLASS;
        $controller = new $imitaion_class_name($this->container->get(Renderer::class));
        $controller->setContainer($this->container);
        $controller->setHandler($this->checkCallableSignature($callable));

        return $controller;
    }


}