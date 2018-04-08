<?php

namespace Gks\Application\Handlers;

use Gks\Application\Commands\UpdateWork as UpdateWorkCommand;
use Gks\Domain\Works\WorksRepository;

class UpdateWork
{
    /**
     * @var WorksRepository
     */
    private $repository;

    /**
     * UpdateWork constructor.
     *
     * @param WorksRepository $repository
     */
    public function __construct(WorksRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param UpdateWorkCommand $command
     */
    public function handle(UpdateWorkCommand $command)
    {
        $this->repository->add($command->getWork());
    }
}
