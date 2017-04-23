<?php

namespace Gks\Domain\Works\Images;

class Image
{
    /**
     * @var ImageId
     */
    private $imageId;

    /**
     * @var string
     */
    private $path;

    /**
     * @param ImageId $imageId
     * @param string $path
     */
    public function __construct(ImageId $imageId, string $path)
    {
        $this->imageId = $imageId;
        $this->path = $path;
    }

    /**
     * @return ImageId
     */
    public function getImageId(): ImageId
    {
        return $this->imageId;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
