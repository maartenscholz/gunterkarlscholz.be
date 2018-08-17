<?php

namespace Gks\Domain\ValueObjects;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class UuidIdentifier
{
    /**
     * @var UuidInterface
     */
    private $value;

    /**
     * @param UuidInterface $value
     */
    protected function __construct(UuidInterface $value)
    {
        $this->value = $value;
    }

    /**
     * @return static
     */
    public static function generate()
    {
        return new static(Uuid::uuid4());
    }

    /**
     * @param string $string
     *
     * @return static
     */
    public static function fromString(string $string)
    {
        return new static(Uuid::fromString($string));
    }

    /**
     * @return UuidInterface
     */
    public function getValue(): UuidInterface
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value->toString();
    }
}
