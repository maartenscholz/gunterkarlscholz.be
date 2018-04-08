<?php

namespace Gks\Tests\Unit\Infrastructure\ValueObjects;

use Gks\Domain\ValueObjects\NonZeroUnsignedInteger;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class NonZeroUnsignedIntegerTest extends TestCase
{
    /**
     * @return array
     */
    public function invalidValues()
    {
        return [
            [0],
            [-1],
            [-100],
        ];
    }

    /**
     * @test
     * @dataProvider invalidValues
     *
     * @param int $value
     */
    public function it_throws_when_constructed_with_invalid_values(int $value)
    {
        $this->expectException(InvalidArgumentException::class);

        new NonZeroUnsignedInteger($value);
    }

    /**
     * @test
     */
    public function it_can_return_its_value()
    {
        $integer = new NonZeroUnsignedInteger(1);

        $this->assertSame(1, $integer->getValue());
    }

    /**
     * @test
     */
    public function it_can_be_cast_to_a_string()
    {
        $integer = new NonZeroUnsignedInteger(2);

        $this->assertSame('2', (string) $integer);
    }
}
