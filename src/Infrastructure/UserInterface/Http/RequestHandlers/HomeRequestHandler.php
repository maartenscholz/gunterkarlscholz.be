<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers;

use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeRequestHandler
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
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $response->getBody()->write($this->templates->render('app'));

        return $response;
    }
}
