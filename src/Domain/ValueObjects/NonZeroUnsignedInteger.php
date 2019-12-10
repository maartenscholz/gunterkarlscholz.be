<?php

namespace Gks\Domain\ValueObjects;

use InvalidArgumentException;

final class NonZeroUnsignedInteger
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Value can not be 0 or less than 0.');
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
