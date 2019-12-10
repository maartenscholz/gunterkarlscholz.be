<?php

namespace Gks\Application\Commands;

use Gks\Domain\Model\Works\Images\ImageId;
use Gks\Domain\Model\Works\WorkId;

final class RemoveImage
{
    private WorkId $workId;

    private ImageId $imageId;

    public function __construct(WorkId $workId, ImageId $imageId)
    {
        $this->workId = $workId;
        $this->imageId = $imageId;
    }

    public function getWorkId(): WorkId
    {
        return $this->workId;
    }

    public function getImageId(): ImageId
    {
        return $this->imageId;
    }
}
