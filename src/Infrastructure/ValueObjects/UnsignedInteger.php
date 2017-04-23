<?php

namespace Gks\Infrastructure\ValueObjects;

use InvalidArgumentException;

class UnsignedInteger
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Value can not be less than zero');
        }

        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString():string
    {
        return (string) $this->value;
    }
}
