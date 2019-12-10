<?php

namespace Gks\Domain\Model\Works;

use InvalidArgumentException;

final class Type
{
    CONST PAINTING = 'painting';
    CONST DRAWING = 'drawing';
    CONST SCULPTURE = 'sculpture';

    CONST TYPES = [
        self::PAINTING,
        self::DRAWING,
        self::SCULPTURE,
    ];

    private string $value;

    public function __construct(string $value)
    {
        if (!in_array($value, static::TYPES)) {
            throw new InvalidArgumentException("$value is not a valid type.");
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function painting()
    {
        return new static(static::PAINTING);
    }

    public static function drawing()
    {
        return new static(static::DRAWING);
    }

    public static function sculpture()
    {
        return new static(static::SCULPTURE);
    }
}
