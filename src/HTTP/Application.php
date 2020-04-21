<?php

namespace LoneCat\Framework\HTTP;

use LoneCat\Framework\HTTP\Middleware\ExceptionMiddleware;
use LoneCat\Framework\HTTP\Middleware\RouteFollowMiddleware;
use LoneCat\Framework\HTTP\Middleware\RouteMatchMiddleware;
use LoneCat\Framework\HTTP\Pipelines\AppPipeline;
use LoneCat\Framework\HTTP\Pipelines\RoutePipeline;
use LoneCat\PSR11\ContainerAware\ContainerAwareTrait;
use LoneCat\PSR11\ContainerAware\ContanerAwareInterface;
use LoneCat\PSR15\Pipeline;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Application
    implements ContanerAwareInterface
{
    use ContainerAwareTrait;

    protected RequestHandlerInterface $not_found_handler;

    public function __construct(RequestHandlerInterface $not_found_handler)
    {
        $this->not_found_handler = $not_found_handler;
    }

    public function setContainer(ContainerInterface $container) {
        $this->container = $container;
    }

    public function run(ServerRequestInterface $request): void
    {
        $pipeline = $this->generatePipeline();

        $response = $pipeline->process($request, $this->not_found_handler);

        $emitter = $this->container->get(Emitter::class);

        $emitter->emit($response);
    }

    protected function generatePipeline(): Pipeline
    {
        $main_pipeline = $this->container->get(AppPipeline::class);

        $init_pipeline = $this->container->get(Pipeline::class);

        $main_pipeline->middleware(ExceptionMiddleware::class)
                      ->middleware($init_pipeline)
                      ->middleware(RouteMatchMiddleware::class)
                      ->middleware(RouteFollowMiddleware::class)
                      ->middleware($this->container->get(RoutePipeline::class));

        return $main_pipeline;
    }

}
