<?php

namespace Gks\Application\Commands;

use Gks\Domain\Model\Works\Images\ImageId;
use Gks\Domain\Model\Works\WorkId;

class RemoveImage
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
     * @param WorkId $workId
     * @param ImageId $imageId
     */
    public function __construct(WorkId $workId, ImageId $imageId)
    {
        $this->workId = $workId;
        $this->imageId = $imageId;
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
}
