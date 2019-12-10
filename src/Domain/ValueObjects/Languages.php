<?php

namespace Gks\Domain\ValueObjects;

final class Languages
{
    public static function getAll()
    {
        return [
            'nl_BE',
            'en_US',
            'fr_FR',
            'de_DE',
        ];
    }
}
