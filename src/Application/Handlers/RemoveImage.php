<?php

namespace Gks\Application\Handlers;

use BigName\EventDispatcher\Dispatcher;
use Gks\Application\Commands\RemoveImage as RemoveImageCommand;
use Gks\Domain\Model\Works\WorkRepository;

final class RemoveImage
{
    private WorkRepository $workRepository;

    private Dispatcher $eventDispatcher;

    public function __construct(WorkRepository $workRepository, Dispatcher $eventDispatcher)
    {
        $this->workRepository = $workRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(RemoveImageCommand $command): void
    {
        $work = $this->workRepository->findById($command->getWorkId());

        $work->removeImage($command->getImageId());

        $this->workRepository->add($work);

        $this->eventDispatcher->dispatch($work->releaseEvents());
    }
}
