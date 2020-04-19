<?php

namespace app\HTTP\Controllers;

use LoneCat\Framework\HTTP\Controllers\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PageNotFoundController
    extends Controller
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->renderResponse('Errors/NotFound', [], 404);
    }
}