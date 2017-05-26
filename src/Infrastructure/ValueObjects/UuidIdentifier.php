<?php

namespace Gks\Infrastructure\ValueObjects;

use Ramsey\Uuid\Uuid;

abstract class UuidIdentifier
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    protected function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return static
     */
    public static function generate()
    {
        return new static(Uuid::uuid4()->toString());
    }

    /**
     * @param $string
     *
     * @return static
     */
    public static function fromString(string $string)
    {
        return new static($string);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue();
    }
}
