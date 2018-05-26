<?php

namespace Gks\Domain\Works\Images;

use Gks\Domain\Model\Works\Images\ImageId;

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
