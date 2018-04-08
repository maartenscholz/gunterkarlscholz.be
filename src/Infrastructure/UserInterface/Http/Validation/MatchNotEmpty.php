<?php

namespace Gks\Infrastructure\UserInterface\Http\Validation;

use InvalidArgumentException;
use Sirius\Validation\Rule\AbstractRule;

class MatchNotEmpty extends AbstractRule
{
    const MESSAGE = 'Value is required when {item} is set.';
    const LABELED_MESSAGE = '{label} is required when {item} is set.';

    const OPTION_ITEM = 'item';

    /**
     * @param mixed $value
     * @param null|mixed $valueIdentifier
     *
     * @return bool
     */
    public function validate($value, $valueIdentifier = null)
    {
        if (!array_key_exists(self::OPTION_ITEM, $this->options)) {
            throw new InvalidArgumentException('Option '.self::OPTION_ITEM.' must be set.');
        }

        $itemSelector = $this->options[self::OPTION_ITEM];
        $itemValue = $this->context->getItemValue($itemSelector);

        return $value !== '' || ($value === '' && $itemValue === '');
    }
}
