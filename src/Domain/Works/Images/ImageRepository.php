<?php

namespace Gks\Domain\Works\Images;

interface ImageRepository
{
    /**
     * @param ImageId $imageId
     *
     * @return void
     */
    public function remove(ImageId $imageId);
}
