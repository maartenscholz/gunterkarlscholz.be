<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works;

use Gks\Application\Commands\RemoveWork;
use Gks\Domain\Works\WorkId;
use League\Tactician\CommandBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

class DestroyRequestHandler
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     *
     * @return RedirectResponse
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $this->commandBus->handle(new RemoveWork(WorkId::fromString($args['id'])));

        return new RedirectResponse('/admin/works');
    }
}
