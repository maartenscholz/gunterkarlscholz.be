<?php

namespace Gks\Domain\Model\Works;

use Gks\Domain\ValueObjects\Languages;
use InvalidArgumentException;

final class Title
{
    /**
     * @var array|string[]
     */
    private $values;

    /**
     * Title constructor.
     *
     * @param array $values
     */
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

    /**
     * @param array $values
     *
     * @return Title
     */
    public static function createFromArray(array $values)
    {
        return new self($values['nl_BE'], $values['en_US']);
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param string $language
     *
     * @return string
     */
    public function getValue($language)
    {
        if (!in_array($language, Languages::getAll())) {
            throw new InvalidArgumentException("Language $language not supported");
        }

        return $this->values[$language];
    }
}
