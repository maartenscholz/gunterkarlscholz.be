<?php

namespace Gks\Application\Handlers;

use Gks\Application\Commands\UpdateWork as UpdateWorkCommand;
use Gks\Domain\Model\Works\WorksRepository;

final class UpdateWork
{
    private WorksRepository $repository;

    public function __construct(WorksRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(UpdateWorkCommand $command): void
    {
        $work = $this->repository->findById($command->getWorkId());

        $work->update($command->getType(), $command->getTitle(), $command->getDescription(), $command->getDimension());

        $this->repository->add($work);
    }
}
