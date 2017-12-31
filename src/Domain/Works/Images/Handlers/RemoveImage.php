<?php

namespace Gks\Domain\Works\Images\Handlers;

use Gks\Domain\Works\Images\Commands\RemoveImage as RemoveImageCommand;
use Gks\Domain\Works\Images\ImageRepository;
use League\Flysystem\FilesystemInterface;

class RemoveImage
{
    /**
     * @var ImageRepository
     */
    private $imageRepository;

    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * @param ImageRepository $imageRepository
     * @param FilesystemInterface $filesystem
     */
    public function __construct(ImageRepository $imageRepository, FilesystemInterface $filesystem)
    {
        $this->imageRepository = $imageRepository;
        $this->filesystem = $filesystem;
    }

    /**
     * @param RemoveImageCommand $command
     */
    public function handle(RemoveImageCommand $command)
    {
        $image = $this->imageRepository->findById($command->getImageId());

        $this->imageRepository->remove($image->getImageId());

        $this->filesystem->delete("/images/source/{$image->getFilename()}");
        $this->filesystem->deleteDir("/images/cache/{$image->getFilename()}");
    }
}
