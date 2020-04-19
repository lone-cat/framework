<?php

namespace app\HTTP\Controllers;

use LoneCat\Framework\HTTP\Controllers\Controller;
use LoneCat\Framework\HTTP\Controllers\ExceptionControllerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ExceptionController
    extends Controller
    implements ExceptionControllerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $exception = $request->getAttribute(\Exception::class);

        return $this->renderResponse('Errors/Exception', ['exception' => $exception], 500);
    }
}