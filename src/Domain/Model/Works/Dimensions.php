<?php

namespace Gks\Domain\Model\Works;

use Gks\Domain\ValueObjects\NonZeroUnsignedInteger;

final class Dimensions
{
    /**
     * @var NonZeroUnsignedInteger
     */
    private $width;

    /**
     * @var NonZeroUnsignedInteger
     */
    private $height;

    /**
     * @param NonZeroUnsignedInteger $width
     * @param NonZeroUnsignedInteger $height
     */
    public function __construct(NonZeroUnsignedInteger $width, NonZeroUnsignedInteger $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @return NonZeroUnsignedInteger
     */
    public function getWidth(): NonZeroUnsignedInteger
    {
        return $this->width;
    }

    /**
     * @return NonZeroUnsignedInteger
     */
    public function getHeight(): NonZeroUnsignedInteger
    {
        return $this->height;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->width.'×'.$this->height;
    }
}
