<?php

namespace Gks\Tests\Unit\Domain\Model;

use Gks\Domain\Events\ImageWasRemoved;
use Gks\Domain\Model\Work;
use Gks\Domain\Model\Works\Description;
use Gks\Domain\Model\Works\Images\ImageId;
use Gks\Domain\Model\Works\Title;
use Gks\Domain\Model\Works\Type;
use Gks\Domain\Model\Works\WorkId;
use PHPUnit\Framework\TestCase;

final class WorkTest extends TestCase
{
    /**
     * @test
     */
    public function it_records_event_when_removing_an_image(): void
    {
        $imageId = ImageId::generate();

        // given
        $work = new Work(
            WorkId::generate(),
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

        $work->addImage($imageId, 'test.jpg', 'test/test.jpg');

        // when
        $work->removeImage($imageId);

        // then
        $this->assertContainsEquals(new ImageWasRemoved($imageId, 'test.jpg'), $work->releaseEvents());
    }
}
