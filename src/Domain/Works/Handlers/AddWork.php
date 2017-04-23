<?php

namespace Gks\Domain\Works\Handlers;

use Gks\Domain\Works\Commands\AddWork as AddWorkCommand;
use Gks\Domain\Works\Work;
use Gks\Domain\Works\WorksRepository;

class AddWork
{
    /**
     * @var WorksRepository
     */
    private $repository;

    /**
     * AddWork constructor.
     *
     * @param WorksRepository $repository
     */
    public function __construct(WorksRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param AddWorkCommand $command
     *
     * @return Work
     */
    public function handle(AddWorkCommand $command)
    {
        $work = new Work($command->getWorkId(), $command->getType(), $command->getTitle(), $command->getDimension());

        $this->repository->add($work);

        return $work;
    }
}
