<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\Images;

use Gks\Application\Commands\RemoveImage;
use Gks\Domain\Model\Works\Images\ImageId;
use Gks\Domain\Model\Works\WorkId;
use League\Tactician\CommandBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RemoveRequestHandler
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
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $workId = WorkId::fromString($args['work_id']);

        $this->commandBus->handle(new RemoveImage(
            $workId,
            ImageId::fromString($args['image_id'])
        ));

        return $response->withHeader('Location', "/admin/works/$workId/images");
    }
}
