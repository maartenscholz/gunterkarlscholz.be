<?php

namespace Gks\Application\Handlers;

use Gks\Application\Commands\AddImage as AddImageCommand;
use Gks\Domain\Model\Works\WorksRepository;

class AddImage
{
    /**
     * @var WorksRepository
     */
    private $worksRepository;

    /**
     * @param WorksRepository $worksRepository
     */
    public function __construct(WorksRepository $worksRepository)
    {
        $this->worksRepository = $worksRepository;
    }

    /**
     * @param AddImageCommand $command
     */
    public function handle(AddImageCommand $command)
    {
        $work = $this->worksRepository->findById($command->getWorkId());

        $work->addImage($command->getImageId(), $command->getImageFilename(), $command->getImageFilename());

        $this->worksRepository->add($work);
    }
}
