<?php

namespace Gks\Application\Http\Controllers\Admin;

use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DashboardController
{
    /**
     * @var Engine
     */
    private $templates;

    /**
     * DashboardController constructor.
     *
     * @param Engine $templates
     */
    public function __construct(Engine $templates)
    {
        $this->templates = $templates;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {
        $response->getBody()->write($this->templates->render('admin::dashboard'));

        return $response;
    }
}
