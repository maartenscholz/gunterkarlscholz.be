<?php

namespace Gks\Domain\Works\Images\Commands;

use Gks\Domain\Works\Images\ImageId;
use Gks\Domain\Works\WorkId;

class AddImageToWork
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
    private $imagePath;

    /**
     * @param WorkId $workId
     * @param ImageId $imageId
     * @param string $imagePath
     */
    public function __construct(WorkId $workId, ImageId $imageId, string $imagePath)
    {
        $this->workId = $workId;
        $this->imageId = $imageId;
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
    public function getImagePath(): string
    {
        return $this->imagePath;
    }
}
