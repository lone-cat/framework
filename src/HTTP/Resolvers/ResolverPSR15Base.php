<?php

namespace LoneCat\Framework\HTTP\Resolvers;

use Closure;
use LoneCat\PSR11\ContainerAware\ContainerAwareTrait;
use LoneCat\PSR11\ContainerAware\ContanerAwareInterface;
use ReflectionFunction;
use ReflectionMethod;

abstract class ResolverPSR15Base
    implements ContanerAwareInterface
{
    use ContainerAwareTrait;

    abstract protected function createImitationFromCallable(callable $callable);

    protected function checkCallableSignature(callable $closure) {
        $reflection_function = $closure instanceof Closure
            ? new ReflectionFunction($closure)
            : new ReflectionMethod($closure[0], $closure[1]);

        $reflection_example = new ReflectionMethod(static::IMITATION_CLASS, static::IMITATION_METHOD);

        $reflection_function_parameters = $reflection_function->getParameters();
        $reflection_example_parameters = $reflection_example->getParameters();

        if (count($reflection_function_parameters) !== count($reflection_example_parameters)) {
            return null;
        }

        foreach ($reflection_example_parameters as $key => $parameter) {
            if (!isset($reflection_function_parameters[$key])) {
                return null;
            }
            if (is_null($reflection_function_parameters[$key]->getClass())) {
                return null;
            }
            if ($parameter->getClass()->getName() !== $reflection_function_parameters[$key]->getClass()->getName()) {
                return null;
            }
        }

        if ($reflection_function->getReturnType()->getName() !== $reflection_example->getReturnType()->getName()) {
            return null;
        }

        return $closure;
    }


    protected function getResolvedResultOrNull($callable_id) {

        if ($callable_id instanceof Closure) {
            return $this->createImitationFromCallable($callable_id);
        }

        if (is_string($callable_id)) {
            $callable_id = $this->getCallableFromString($callable_id);
        }

        if (is_array($callable_id)) {
            $callable_id = $this->prepareArrayForCall($callable_id);
        }

        if (is_callable($callable_id)) {
            return $this->createImitationFromCallable($callable_id);
        }

        if (is_string($callable_id) && $this->container->has($callable_id)) {
            return $this->container->get($callable_id);
        }

        return null;
    }

    /**
     * Function tries to split callable string into pieces from form "ClassName::Method", if no success returns
     *
     * @param string $string
     * @param string $delimeter
     * @return false|mixed|string|string[]
     */
    protected function getCallableFromString(string $string, string $delimeter = '::') {
        $callable_array = explode($delimeter, $string);
        if (count($callable_array) < 2) {
            return $string;
        }

        $callable_array = [
            $callable_array[0],
            $callable_array[1]
        ];

        return $callable_array;
    }

    protected function prepareArrayForCall(array $array) {
        if (count($array) < 1) {
            return $array;
        }

        $callable = $array;
        reset($callable);
        if (count($callable) === 1) {
            $callable_class = key($callable);
            $callable = [$callable_class, $array[$callable_class]];
        }

        if (!class_exists($callable[0])) {
            return $array;
        }

        if (!method_exists($callable[0], $callable[1])) {
            return $array;
        }

        $reflection_method = new ReflectionMethod($callable[0], $callable[1]);
        if ($reflection_method->isStatic()) {
            return $callable;
        }

        $callable[0] = $this->container->get($callable[0]);

        return $callable;
    }

    protected function stringifyHandlerId($handler_id) {
        if (is_array($handler_id)) {
            $handler_id = \json_encode($handler_id, \JSON_UNESCAPED_UNICODE);
        }
        return $handler_id;
    }

}