<?php

namespace Gks\Application\Handlers;

use BigName\EventDispatcher\Dispatcher;
use Gks\Application\Commands\RemoveImage as RemoveImageCommand;
use Gks\Domain\Model\Works\WorksRepository;

final class RemoveImage
{
    private WorksRepository $worksRepository;

    private Dispatcher $eventDispatcher;

    public function __construct(WorksRepository $worksRepository, Dispatcher $eventDispatcher)
    {
        $this->worksRepository = $worksRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(RemoveImageCommand $command): void
    {
        $work = $this->worksRepository->findById($command->getWorkId());

        $work->removeImage($command->getImageId());

        $this->worksRepository->add($work);

        $this->eventDispatcher->dispatch($work->releaseEvents());
    }
}
