<?php

namespace Gks\Domain\ValueObjects;

use InvalidArgumentException;

final class UnsignedInteger
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Value can not be less than zero');
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
