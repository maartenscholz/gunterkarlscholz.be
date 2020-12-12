<?php

namespace Gks\Application\Handlers;

use Gks\Application\Commands\AddWork as AddWorkCommand;
use Gks\Domain\Model\Work;
use Gks\Domain\Model\Works\WorkRepository;

final class AddWork
{
    private WorkRepository $workRepository;

    public function __construct(WorkRepository $workRepository)
    {
        $this->workRepository = $workRepository;
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

        $this->workRepository->add($work);
    }
}
