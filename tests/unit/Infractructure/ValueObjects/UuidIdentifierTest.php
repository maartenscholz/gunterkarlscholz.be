<?php

namespace Gks\Tests\Unit\Infrastructure\ValueObjects;

use Gks\Infrastructure\ValueObjects\UuidIdentifier;
use PHPUnit\Framework\TestCase;

class UuidIdentifierTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_generate_itself()
    {
        $id = $this->getMockForAbstractClass(UuidIdentifier::class, [], '', false);

        $this->assertInstanceOf(UuidIdentifier::class, $id::generate());
    }

    /**
     * @test
     */
    public function it_can_be_created_from_a_string()
    {
        $id = $this->getMockForAbstractClass(UuidIdentifier::class, [], '', false);
        $id = $id::fromString('c9a2eab4-84ef-4844-b5a7-e4c0591d58cb');

        $this->assertInstanceOf(UuidIdentifier::class, $id);
        $this->assertSame('c9a2eab4-84ef-4844-b5a7-e4c0591d58cb', (string) $id->getValue());
    }

    /**
     * @test
     */
    public function it_can_returns_its_value()
    {
        $id = $this->getMockForAbstractClass(UuidIdentifier::class, [], '', false);
        $id = $id::fromString('c9a2eab4-84ef-4844-b5a7-e4c0591d58cb');

        $this->assertSame('c9a2eab4-84ef-4844-b5a7-e4c0591d58cb', (string) $id->getValue());
    }

    /**
     * @test
     */
    public function it_can_be_casted_to_a_string()
    {
        $id = $this->getMockForAbstractClass(UuidIdentifier::class, [], '', false);
        $id = $id::fromString('c9a2eab4-84ef-4844-b5a7-e4c0591d58cb');

        $this->assertSame('c9a2eab4-84ef-4844-b5a7-e4c0591d58cb', (string) $id);
    }
}
