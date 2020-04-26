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
        $display = (bool)(ini_get('display_errors') === '1');

        return $this->renderResponse('Errors/Exception', ['exception' => $exception, 'display' => $display], 500);
    }
}