<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\Images;

use Gks\Application\Commands\RemoveImage;
use Gks\Domain\Model\Works\Images\ImageId;
use Gks\Domain\Model\Works\WorkId;
use League\Tactician\CommandBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

final class RemoveRequestHandler
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $workId = WorkId::fromString($args['work_id']);

        $this->commandBus->handle(
            new RemoveImage(
                $workId,
                ImageId::fromString($args['image_id'])
            )
        );

        return new RedirectResponse("/admin/works/$workId/images");
    }
}
