<?php

namespace Gks\Application\Handlers;

use Gks\Application\Commands\RemoveImage as RemoveImageCommand;
use Gks\Domain\Model\Works\WorksRepository;
use League\Flysystem\FilesystemInterface;

class RemoveImage
{
    /**
     * @var WorksRepository
     */
    private $worksRepository;

    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * @param WorksRepository $worksRepository
     * @param FilesystemInterface $filesystem
     */
    public function __construct(WorksRepository $worksRepository, FilesystemInterface $filesystem)
    {
        $this->worksRepository = $worksRepository;
        $this->filesystem = $filesystem;
    }

    /**
     * @param RemoveImageCommand $command
     */
    public function handle(RemoveImageCommand $command)
    {
        $work = $this->worksRepository->findById($command->getWorkId());

        $image = $work->getImage($command->getImageId());

        $work->removeImage($command->getImageId());

        $this->worksRepository->add($work);

        $this->filesystem->delete("/images/source/{$image->getFilename()}");
        $this->filesystem->deleteDir("/images/cache/{$image->getFilename()}");
    }
}
