<?php

namespace Gks\Application\Handlers;

use Gks\Application\Commands\AddImage as AddImageCommand;
use Gks\Domain\Model\Works\WorksRepository;

final class AddImage
{
    private WorksRepository $worksRepository;

    public function __construct(WorksRepository $worksRepository)
    {
        $this->worksRepository = $worksRepository;
    }

    public function handle(AddImageCommand $command): void
    {
        $work = $this->worksRepository->findById($command->getWorkId());

        $work->addImage($command->getImageId(), $command->getImageFilename(), $command->getImageFilename());

        $this->worksRepository->add($work);
    }
}
