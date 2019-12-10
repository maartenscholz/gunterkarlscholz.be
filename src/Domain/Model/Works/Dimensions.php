<?php

namespace Gks\Domain\Model\Works;

use Gks\Domain\ValueObjects\NonZeroUnsignedInteger;

final class Dimensions
{
    private NonZeroUnsignedInteger $width;

    private NonZeroUnsignedInteger $height;

    public function __construct(NonZeroUnsignedInteger $width, NonZeroUnsignedInteger $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function getWidth(): NonZeroUnsignedInteger
    {
        return $this->width;
    }

    public function getHeight(): NonZeroUnsignedInteger
    {
        return $this->height;
    }

    public function __toString(): string
    {
        return $this->width.'×'.$this->height;
    }
}
