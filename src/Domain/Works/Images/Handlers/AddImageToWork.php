<?php

namespace Gks\Domain\Works\Images\Handlers;

use Gks\Domain\Works\Images\Commands\AddImageToWork as AddImageToWorkCommand;
use Gks\Domain\Works\Images\Image;
use Gks\Domain\Works\WorksRepository;

class AddImageToWork
{
    /**
     * @var ImagesRepository
     */
    private $imagesRepository;

    /**
     * @var WorksRepository
     */
    private $worksRepository;

    /**
     * @param ImagesRepository $imagesRepository
     * @param WorksRepository $worksRepository
     */
    public function __construct(ImagesRepository $imagesRepository, WorksRepository $worksRepository)
    {
        $this->imagesRepository = $imagesRepository;
        $this->worksRepository = $worksRepository;
    }

    /**
     * @param AddImageToWorkCommand $command
     */
    public function handle(AddImageToWorkCommand $command)
    {
        $work = $this->worksRepository->findById($command->getWorkId());

        $image = new Image($command->getImageId(), $command->getImagePath());

        $work->addImage($image);

        $this->worksRepository->add($work);
    }
}
