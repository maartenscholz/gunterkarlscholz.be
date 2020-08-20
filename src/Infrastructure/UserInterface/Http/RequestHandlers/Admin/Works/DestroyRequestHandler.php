<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works;

use Gks\Application\Commands\RemoveWork;
use Gks\Domain\Model\Works\WorkId;
use Laminas\Diactoros\Response\RedirectResponse;
use League\Tactician\CommandBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DestroyRequestHandler
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $this->commandBus->handle(new RemoveWork(WorkId::fromString($args['id'])));

        return new RedirectResponse('/admin/works');
    }
}
