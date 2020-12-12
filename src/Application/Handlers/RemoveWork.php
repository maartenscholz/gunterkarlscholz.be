<?php

namespace Gks\Application\Handlers;

use BigName\EventDispatcher\Dispatcher;
use Gks\Application\Commands\RemoveWork as RemoveWorkCommand;
use Gks\Domain\Model\Works\WorkRepository;

final class RemoveWork
{
    private WorkRepository $workRepository;

    private Dispatcher $eventDispatcher;

    public function __construct(WorkRepository $workRepository, Dispatcher $eventDispatcher)
    {
        $this->workRepository = $workRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(RemoveWorkCommand $command): void
    {
        $work = $this->workRepository->findById($command->getWorkId());

        $work->removeAllImages();

        $this->workRepository->remove($command->getWorkId());

        $this->eventDispatcher->dispatch($work->releaseEvents());
    }
}
