<?php

namespace LoneCat\Framework\HTTP\Middleware;

use LoneCat\Framework\HTTP\Pipelines\RoutePipeline;
use LoneCat\Router\Result;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteFollowMiddleware
    extends Middleware
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var Result $result */
        $result = $request->getAttribute(Result::class);
        if (!$result instanceof Result)
            return $handler->handle($request);

        $controller = $result->getRequestHandler();

        $pipeline = $this->container->get(RoutePipeline::class);

        foreach ($result->getMiddlewares() as $middleware) {
            $pipeline->middleware($middleware);
        }

        return $pipeline->process($request, $controller);
    }

}