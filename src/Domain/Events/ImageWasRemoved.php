<?php

namespace Gks\Domain\Events;

use BigName\EventDispatcher\Event;
use Gks\Domain\Model\Works\Images\ImageId;

final class ImageWasRemoved implements Event
{
    private ImageId $imageId;

    private string $fileName;

    public function __construct(ImageId $imageId, string $fileName)
    {
        $this->imageId = $imageId;
        $this->fileName = $fileName;
    }

    public function getName(): string
    {
        return self::class;
    }

    public function getImageId(): ImageId
    {
        return $this->imageId;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }
}
