<?php

namespace Gks\Domain\Works\Images;

interface ImageRepository
{
    /**
     * @param ImageId $imageId
     *
     * @return Image
     */
    public function findById(ImageId $imageId);

    /**
     * @param ImageId $imageId
     *
     * @return void
     */
    public function remove(ImageId $imageId);
}
