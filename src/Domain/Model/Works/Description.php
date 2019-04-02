<?php

namespace Gks\Domain\Model\Works;

use Gks\Domain\ValueObjects\Languages;
use InvalidArgumentException;

final class Description
{
    /**
     * @var string[]
     */
    private $values;

    public function __construct(array $values)
    {
        $processedLanguages = [];

        foreach (Languages::getAll() as $language) {
            if (!array_key_exists($language, $values)) {
                throw new InvalidArgumentException("No value found for the $language language.");
            }
        }

        foreach ($values as $language => $value) {
            if (in_array($language, Languages::getAll())) {
                $processedLanguages[$language] = $value;
            }
        }

        $this->values = $processedLanguages;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getValue(string $language): string
    {
        if (!in_array($language, Languages::getAll())) {
            throw new InvalidArgumentException("Language $language not supported");
        }

        return $this->values[$language] ?: '';
    }
}
