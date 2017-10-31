<?php

namespace Gks\Domain\Works\Images\Handlers;

use Gks\Domain\Works\Images\Commands\RemoveImage as RemoveImageCommand;
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
    }
}