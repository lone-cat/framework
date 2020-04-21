<?php

namespace app\HTTP\Controllers;

use LoneCat\Framework\HTTP\Controllers\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DefaultController
    extends Controller
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->renderResponse('App/Main');
    }

    public function page2(ServerRequestInterface $request): ResponseInterface
    {
        return $this->renderResponse('App/Page2');
    }

}