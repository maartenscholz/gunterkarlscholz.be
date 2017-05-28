<?php

namespace Gks\Domain\Works\Images\Handlers;

use Gks\Domain\Works\Images\Commands\AddImage as AddImageCommand;
use Gks\Domain\Works\Images\Image;
use Gks\Domain\Works\WorksRepository;

class AddImage
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
     * @param AddImageCommand $command
     */
    public function handle(AddImageCommand $command)
    {
        $work = $this->worksRepository->findById($command->getWorkId());

        $image = new Image($command->getImageId(), $command->getImagePath());

        $work->addImage($image);

        $this->worksRepository->add($work);
    }
}
