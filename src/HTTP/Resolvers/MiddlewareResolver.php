<?php

namespace LoneCat\Framework\HTTP\Resolvers;

use LoneCat\Framework\HTTP\Middleware\Middleware;
use LoneCat\PSR15\MiddlewareResolverInterface;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareResolver
    extends ResolverPSR15Base
    implements MiddlewareResolverInterface
{

    protected const IMITATION_CLASS = MiddlewareImitation::class;
    protected const IMITATION_METHOD = 'process';

    public function resolve($middleware_id): MiddlewareInterface
    {
        $middleware = $this->getResolvedResultOrNull($middleware_id);
        if (!$middleware instanceof MiddlewareInterface) {
            throw new \Exception('Middleware "' . $this->stringifyHandlerId($middleware_id) . '" could not be resolved!');
        }
        return $middleware;
    }

    protected function createImitationFromCallable(callable $callable): Middleware {
        $imitation_class_name = self::IMITATION_CLASS;
        $middleware = new $imitation_class_name;
        $middleware->setContainer($this->container);
        $middleware->setHandler($this->checkCallableSignature($callable));

        return $middleware;
    }
}