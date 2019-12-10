<?php

namespace Gks\Application\Listeners;

use BigName\EventDispatcher\Event;
use BigName\EventDispatcher\Listener;
use Gks\Domain\Events\ImageWasRemoved;
use League\Flysystem\FilesystemInterface;

final class RemoveImageFiles implements Listener
{
    private FilesystemInterface $filesystem;

    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function handle(Event $event): void
    {
        if (!$event instanceof ImageWasRemoved) {
            return;
        }

        $this->filesystem->delete("/images/source/{$event->getFileName()}");
        $this->filesystem->deleteDir("/images/cache/{$event->getFileName()}");
    }
}
