<?php

namespace Gks\Domain\Model\Works;

use InvalidArgumentException;

final class Type
{
    private const PAINTING = 'painting';
    private const DRAWING = 'drawing';
    private const SCULPTURE = 'sculpture';

    private const TYPES = [
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

    /**
     * @return Type[]
     */
    public static function all(): array
    {
        return [
            self::painting(),
            self::drawing(),
            self::sculpture(),
        ];
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
