<?php

namespace Gks\Application\Handlers;

use BigName\EventDispatcher\Dispatcher;
use Gks\Application\Commands\RemoveWork as RemoveWorkCommand;
use Gks\Domain\Model\Works\WorksRepository;

final class RemoveWork
{
    /**
     * @var WorksRepository
     */
    private $repository;

    /**
     * @var Dispatcher
     */
    private $eventDispatcher;

    public function __construct(WorksRepository $repository, Dispatcher $eventDispatcher)
    {
        $this->repository = $repository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param RemoveWorkCommand $command
     */
    public function handle(RemoveWorkCommand $command)
    {
        $work = $this->repository->findById($command->getWorkId());

        $work->removeAllImages();

        $this->repository->remove($command->getWorkId());

        $this->eventDispatcher->dispatch($work->releaseEvents());
    }
}
