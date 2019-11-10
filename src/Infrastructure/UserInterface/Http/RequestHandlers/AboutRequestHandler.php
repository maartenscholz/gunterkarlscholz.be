<?php

declare(strict_types=1);

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers;

use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

final class AboutRequestHandler
{
    /**
     * @var Engine
     */
    private $templates;

    public function __construct(Engine $templates)
    {
        $this->templates = $templates;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();

        $response->getBody()->write($this->templates->render('about'));

        return $response;
    }
}
