<?php

namespace Gks\Tests\Unit\Infrastructure\ValueObjects;

use Gks\Infrastructure\ValueObjects\UnsignedInteger;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UnsignedIntegerTest extends TestCase
{
    /**
     * @return array
     */
    public function invalidValues()
    {
        return [
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

        new UnsignedInteger($value);
    }

    /**
     * @test
     */
    public function it_can_return_its_value()
    {
        $integer = new UnsignedInteger(0);

        $this->assertSame(0, $integer->getValue());
    }

    /**
     * @test
     */
    public function it_can_be_cast_to_a_string()
    {
        $integer = new UnsignedInteger(1);

        $this->assertSame('1', (string) $integer);
    }
}
