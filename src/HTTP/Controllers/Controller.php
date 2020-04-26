<?php

namespace LoneCat\Framework\HTTP\Controllers;

use LoneCat\Framework\Factories\StreamFactory;
use LoneCat\Framework\HTTP\Factories\ResponseFactory;
use LoneCat\TemplateEngine\Renderer;
use LoneCat\PSR11\ContainerAware\ContainerAwareTrait;
use LoneCat\PSR11\ContainerAware\ContanerAwareInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class Controller
    implements RequestHandlerInterface,
    ContanerAwareInterface
{
    use ContainerAwareTrait;

    protected Renderer $renderer;

    public function __construct(Renderer $renderer) {
        $this->renderer = $renderer;
    }

    abstract public function handle(ServerRequestInterface $request): ResponseInterface;

    protected function renderResponse(string $template, array $params = [], int $code = 200) {
        return $this->createResponse($this->renderer->render($template, $params), $code);
    }

    protected function createResponse(?string $body = null, int $code = 200): ResponseInterface {
        /** @var ResponseFactory $response_factory */
        $response_factory = $this->container->get(ResponseFactoryInterface::class);
        $response = $response_factory->createResponse($code);

        /** @var StreamFactory $stream_factory */
        $stream_factory = $this->container->get(StreamFactoryInterface::class);

        return $response->withBody($stream_factory->createStream($body ?? ''));
    }

}