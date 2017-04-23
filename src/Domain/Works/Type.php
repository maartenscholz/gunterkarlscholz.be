<?php

namespace Gks\Domain\Works;

use InvalidArgumentException;

class Type
{
    CONST PAINTING = 'painting';
    CONST DRAWING = 'drawing';
    CONST SCULPTURE = 'sculpture';

    CONST TYPES = [
        self::PAINTING,
        self::DRAWING,
        self::SCULPTURE,
    ];

    /**
     * @var string
     */
    private $value;

    /**
     * Type constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (!in_array($value, static::TYPES)) {
            throw new InvalidArgumentException("$value is not a valid type.");
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return static
     */
    public static function painting()
    {
        return new static(static::PAINTING);
    }

    /**
     * @return static
     */
    public static function drawing()
    {
        return new static(static::DRAWING);
    }

    /**
     * @return static
     */
    public static function sculpture()
    {
        return new static(static::SCULPTURE);
    }
}
