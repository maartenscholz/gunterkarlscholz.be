<?php

namespace Gks\Application\Commands;

use Gks\Domain\Model\Works\Images\ImageId;
use Gks\Domain\Model\Works\WorkId;

final class AddImage
{
    private WorkId $workId;

    private ImageId $imageId;

    private string $imageFilename;

    private string $imagePath;

    public function __construct(WorkId $workId, ImageId $imageId, string $imageFilename, string $imagePath)
    {
        $this->workId = $workId;
        $this->imageId = $imageId;
        $this->imageFilename = $imageFilename;
        $this->imagePath = $imagePath;
    }

    public function getWorkId(): WorkId
    {
        return $this->workId;
    }

    public function getImageId(): ImageId
    {
        return $this->imageId;
    }

    public function getImageFilename(): string
    {
        return $this->imageFilename;
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
    }
}
