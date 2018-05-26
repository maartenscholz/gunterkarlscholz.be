<?php

namespace Gks\Domain\Works\Images;

use Gks\Domain\Model\Works\Images\ImageId;

class Image
{
    /**
     * @var ImageId
     */
    private $imageId;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $path;

    /**
     * @param ImageId $imageId
     * @param string $filename
     * @param string $path
     */
    public function __construct(ImageId $imageId, string $filename, string $path)
    {
        $this->imageId = $imageId;
        $this->filename = $filename;
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
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
