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
    protected function __construct($value)
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
    public static function fromString($string)
    {
        return new static($string);
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getValue();
    }
}
