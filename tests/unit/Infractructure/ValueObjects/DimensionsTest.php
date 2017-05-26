<?php

namespace Gks\Tests\Unit\Infrastructure\ValueObjects;

use Gks\Infrastructure\ValueObjects\Dimensions;
use Gks\Infrastructure\ValueObjects\NonZeroUnsignedInteger;
use PHPUnit\Framework\TestCase;

class DimensionsTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_the_width_and_height()
    {
        $width = new NonZeroUnsignedInteger(100);
        $height = new NonZeroUnsignedInteger(75);

        $dimensions = new Dimensions($width, $height);

        $this->assertEquals($width, $dimensions->getWidth());
        $this->assertEquals($height, $dimensions->getHeight());
    }

    /**
     * @test
     */
    public function it_can_be_cast_to_a_string()
    {
        $dimensions = new Dimensions(new NonZeroUnsignedInteger(100), new NonZeroUnsignedInteger(75));

        $this->assertEquals('100x75', (string) $dimensions);
    }
}
