<?php

namespace Gks\Domain\ValueObjects;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class UuidIdentifier
{
    private UuidInterface $value;

    final protected function __construct(UuidInterface $value)
    {
        $this->value = $value;
    }

    public static function generate()
    {
        return new static(Uuid::uuid4());
    }

    public static function fromString(string $string)
    {
        return new static(Uuid::fromString($string));
    }

    public function getValue(): UuidInterface
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value->toString();
    }
}
