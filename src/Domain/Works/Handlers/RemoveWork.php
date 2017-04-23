<?php

namespace Gks\Domain\Works\Handlers;

use Gks\Domain\Works\Commands\RemoveWork as RemoveWorkCommand;
use Gks\Domain\Works\WorksRepository;

class RemoveWork
{
    /**
     * @var WorksRepository
     */
    private $repository;

    /**
     * RemoveWork constructor.
     *
     * @param WorksRepository $repository
     */
    public function __construct(WorksRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param RemoveWorkCommand $command
     */
    public function handle(RemoveWorkCommand $command)
    {
        $this->repository->remove($command->getWorkId());
    }
}
