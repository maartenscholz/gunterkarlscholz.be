<?php

namespace Gks\Application\Handlers;

use Gks\Application\Commands\AddImage as AddImageCommand;
use Gks\Domain\Model\Works\WorkRepository;

final class AddImage
{
    private WorkRepository $workRepository;

    public function __construct(WorkRepository $workRepository)
    {
        $this->workRepository = $workRepository;
    }

    public function handle(AddImageCommand $command): void
    {
        $work = $this->workRepository->findById($command->getWorkId());

        $work->addImage($command->getImageId(), $command->getImageFilename(), $command->getImageFilename());

        $this->workRepository->add($work);
    }
}
