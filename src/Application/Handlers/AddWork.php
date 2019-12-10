<?php

namespace Gks\Application\Handlers;

use Gks\Application\Commands\AddWork as AddWorkCommand;
use Gks\Domain\Model\Work;
use Gks\Domain\Model\Works\WorksRepository;

final class AddWork
{
    private WorksRepository $repository;

    public function __construct(WorksRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(AddWorkCommand $command): void
    {
        $work = new Work(
            $command->getWorkId(),
            $command->getType(),
            $command->getTitle(),
            $command->getDescription(),
            $command->getDimension()
        );

        $this->repository->add($work);
    }
}
