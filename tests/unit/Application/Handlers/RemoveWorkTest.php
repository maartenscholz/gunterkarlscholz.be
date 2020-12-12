<?php

namespace Gks\Tests\Unit\Application\Handlers;

use BigName\EventDispatcher\Dispatcher;
use Gks\Application\Commands\RemoveWork as RemoveWorkCommand;
use Gks\Application\Handlers\RemoveWork;
use Gks\Domain\Events\ImageWasRemoved;
use Gks\Domain\Model\Work;
use Gks\Domain\Model\Works\Description;
use Gks\Domain\Model\Works\Images\ImageId;
use Gks\Domain\Model\Works\Title;
use Gks\Domain\Model\Works\Type;
use Gks\Domain\Model\Works\WorkId;
use Gks\Domain\Model\Works\WorkRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class RemoveWorkTest extends TestCase
{
    /**
     * @var WorkRepository|MockObject
     */
    private $workRepository;

    /**
     * @var Dispatcher|MockObject
     */
    private $eventDispatcher;

    /**
     * @var RemoveWork
     */
    private $handler;

    public function setUp(): void
    {
        $this->workRepository = $this->createMock(WorkRepository::class);
        $this->eventDispatcher = $this->createMock(Dispatcher::class);

        $this->handler = new RemoveWork($this->workRepository, $this->eventDispatcher);
    }

    /**
     * @test
     */
    public function it_dispatches_the_correct_event(): void
    {
        $workId = WorkId::generate();
        $imageId1 = ImageId::generate();
        $imageId2 = ImageId::generate();
        $imageFileName1 = 'test1.jpg';
        $imageFileName2 = 'test2.jpg';

        $work = new Work(
            $workId,
            Type::painting(),
            new Title(
                [
                    'nl_BE' => 'title',
                    'en_US' => 'title',
                    'fr_FR' => 'title',
                    'de_DE' => 'title',
                ]
            ),
            new Description(
                [
                    'nl_BE' => null,
                    'en_US' => null,
                    'fr_FR' => null,
                    'de_DE' => null,
                ]
            )
        );
        $work->addImage($imageId1, $imageFileName1, 'test/test1.jpg');
        $work->addImage($imageId2, $imageFileName2, 'test/test2.jpg');
        $work->releaseEvents();

        $this->workRepository->expects($this->any())
            ->method('findById')
            ->with($workId)
            ->willReturn($work);

        $this->eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with(
                [
                    new ImageWasRemoved($imageId1, $imageFileName1),
                    new ImageWasRemoved($imageId2, $imageFileName2),
                ]
            );

        $this->handler->handle(new RemoveWorkCommand($workId));
    }
}
