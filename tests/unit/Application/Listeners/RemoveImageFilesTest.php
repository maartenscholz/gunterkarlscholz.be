<?php

namespace Gks\Tests\Unit\Application\Listeners;

use BigName\EventDispatcher\Event;
use Gks\Domain\Events\ImageWasRemoved;
use Gks\Domain\Model\Works\Images\ImageId;
use Gks\Infrastructure\Filesystem\EventListeners\RemoveImageFiles;
use League\Flysystem\FilesystemInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class RemoveImageFilesTest extends TestCase
{
    /**
     * @var FilesystemInterface|MockObject
     */
    private $filesystem;

    /**
     * @var Event|MockObject
     */
    private $mockEvent;

    /**
     * @var RemoveImageFiles
     */
    private $listener;

    public function setUp(): void
    {
        $this->filesystem = $this->createMock(FilesystemInterface::class);
        $this->mockEvent = $this->createMock(Event::class);

        $this->listener = new RemoveImageFiles($this->filesystem);
    }

    /**
     * @test
     */
    public function it_remove_the_files_from_the_filesystem(): void
    {
        $this->filesystem->expects($this->once())
            ->method('delete')
            ->with('/images/source/test.jpg');

        $this->filesystem->expects($this->once())
            ->method('deleteDir')
            ->with('/images/cache/test.jpg');

        $this->listener->handle(new ImageWasRemoved(ImageId::generate(), 'test.jpg'));
    }

    /**
     * @test
     */
    public function it_does_nothing_when_another_event_is_passed(): void
    {
        $this->filesystem->expects($this->never())
            ->method('delete');

        $this->filesystem->expects($this->never())
            ->method('deleteDir');

        $this->listener->handle($this->mockEvent);
    }
}
