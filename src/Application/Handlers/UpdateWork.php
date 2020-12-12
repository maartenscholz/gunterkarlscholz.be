<?php

namespace Gks\Application\Handlers;

use Gks\Application\Commands\UpdateWork as UpdateWorkCommand;
use Gks\Domain\Model\Works\WorkRepository;

final class UpdateWork
{
    private WorkRepository $workRepository;

    public function __construct(WorkRepository $repository)
    {
        $this->workRepository = $repository;
    }

    public function handle(UpdateWorkCommand $command): void
    {
        $work = $this->workRepository->findById($command->getWorkId());

        $work->update($command->getType(), $command->getTitle(), $command->getDescription(), $command->getDimension());

        $this->workRepository->add($work);
    }
}
