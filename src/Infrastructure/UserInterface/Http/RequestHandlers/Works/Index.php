<?php

declare(strict_types=1);

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Works;

use Gks\Application\Commands\ViewWorks;
use Laminas\Diactoros\Response;
use League\Plates\Engine;
use League\Tactician\CommandBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Index
{
    private Engine $templates;

    private CommandBus $commandBus;

    public function __construct(Engine $templates, CommandBus $commandBus)
    {
        $this->templates = $templates;
        $this->commandBus = $commandBus;
    }

    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $response = new Response();

        $works = $this->commandBus->handle(new ViewWorks());

        $response->getBody()->write($this->templates->render('works/index', compact('works')));

        return $response;
    }
}
