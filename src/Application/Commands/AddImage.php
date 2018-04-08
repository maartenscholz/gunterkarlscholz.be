<?php

namespace Gks\Application\Commands;

use Gks\Domain\Works\Images\ImageId;
use Gks\Domain\Works\WorkId;

class AddImage
{
    /**
     * @var WorkId
     */
    private $workId;

    /**
     * @var ImageId
     */
    private $imageId;

    /**
     * @var string
     */
    private $imageFilename;

    /**
     * @var string
     */
    private $imagePath;

    /**
     * @param WorkId $workId
     * @param ImageId $imageId
     * @param string $imageFilename
     * @param string $imagePath
     */
    public function __construct(WorkId $workId, ImageId $imageId, string $imageFilename, string $imagePath)
    {
        $this->workId = $workId;
        $this->imageId = $imageId;
        $this->imageFilename = $imageFilename;
        $this->imagePath = $imagePath;
    }

    /**
     * @return WorkId
     */
    public function getWorkId(): WorkId
    {
        return $this->workId;
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
    public function getImageFilename(): string
    {
        return $this->imageFilename;
    }

    /**
     * @return string
     */
    public function getImagePath(): string
    {
        return $this->imagePath;
    }
}
