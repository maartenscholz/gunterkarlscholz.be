<?php

namespace Gks\Tests\Unit\Application\Listeners;

use BigName\EventDispatcher\Event;
use Gks\Application\Listeners\RemoveImageFiles;
use Gks\Domain\Events\ImageWasRemoved;
use Gks\Domain\Model\Works\Images\ImageId;
use League\Flysystem\FilesystemInterface;
use PHPUnit\Framework\TestCase;

final class RemoveImageFilesTest extends TestCase
{
    /**
     * @test
     */
    public function it_remove_the_files_from_the_filesystem(): void
    {
        $filesystem = $this->createMock(FilesystemInterface::class);

        $filesystem->expects($this->once())
            ->method('delete')
            ->with('/images/source/test.jpg');

        $filesystem->expects($this->once())
            ->method('deleteDir')
            ->with('/images/cache/test.jpg');

        (new RemoveImageFiles($filesystem))->handle(new ImageWasRemoved(ImageId::generate(), 'test.jpg'));
    }

    /**
     * @test
     */
    public function it_does_nothing_when_another_event_is_passed(): void
    {
        $event = $this->createMock(Event::class);
        $filesystem = $this->createMock(FilesystemInterface::class);

        $filesystem->expects($this->never())
            ->method('delete');

        $filesystem->expects($this->never())
            ->method('deleteDir');

        (new RemoveImageFiles($filesystem))->handle($event);
    }
}
