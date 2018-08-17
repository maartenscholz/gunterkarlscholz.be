<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works;

use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class AddRequestHandler
{
    /**
     * @var Engine
     */
    private $templates;

    /**
     * @param Engine $templates
     */
    public function __construct(Engine $templates)
    {
        $this->templates = $templates;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $response = new Response();

        $response->getBody()->write($this->templates->render('admin::works/create'));

        return $response;
    }
}
