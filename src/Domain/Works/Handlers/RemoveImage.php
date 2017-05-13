<?php

namespace Gks\Domain\Works\Handlers;

use Gks\Domain\Works\Commands\RemoveImage as RemoveImageCommand;
use Gks\Domain\Works\Images\ImageRepository;

class RemoveImage
{
    /**
     * @var ImageRepository
     */
    private $imageRepository;

    /**
     * @param ImageRepository $imageRepository
     */
    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    /**
     * @param RemoveImageCommand $command
     */
    public function handle(RemoveImageCommand $command)
    {
        $this->imageRepository->remove($command->getImageId());

//        unlink(__DIR__.'/../../../../storage/images/source')
    }
}
