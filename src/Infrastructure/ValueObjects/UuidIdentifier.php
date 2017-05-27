<?php

namespace Gks\Infrastructure\ValueObjects;

use Ramsey\Uuid\Uuid;

abstract class UuidIdentifier
{
    /**
     * @var Uuid
     */
    private $value;

    /**
     * @param Uuid $value
     */
    protected function __construct(Uuid $value)
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
     * @param $string
     *
     * @return static
     */
    public static function fromString(string $string)
    {
        return new static(Uuid::fromString($string));
    }

    /**
     * @return Uuid
     */
    public function getValue(): Uuid
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->getValue();
    }
}
