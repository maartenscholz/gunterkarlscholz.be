<?php

namespace Gks\Domain\Works;

use Gks\Domain\Works\Images\ImageId;
use Gks\Infrastructure\ValueObjects\Dimensions;
use Gks\Domain\Works\Images\Image;

class Work
{
    /**
     * @var WorkId
     */
    private $workId;

    /**
     * @var Type
     */
    private $type;

    /**
     * @var Title
     */
    private $title;

    /**
     * @var Dimensions
     */
    private $dimensions;

    /**
     * @var array
     */
    private $images = [];

    /**
     * Work constructor.
     *
     * @param WorkId $workId
     * @param Type $type
     * @param Title $title
     * @param Dimensions $dimensions
     */
    public function __construct(WorkId $workId, Type $type, Title $title, Dimensions $dimensions = null)
    {
        $this->workId = $workId;
        $this->type = $type;
        $this->title = $title;
        $this->dimensions = $dimensions;
    }

    /**
     * @return WorkId
     */
    public function getWorkId(): WorkId
    {
        return $this->workId;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @return Title
     */
    public function getTitle(): Title
    {
        return $this->title;
    }

    /**
     * @return Dimensions
     */
    public function getDimensions()
    {
        return $this->dimensions;
    }

    /**
     * @param Image $image
     */
    public function addImage(Image $image)
    {
        $this->images[(string) $image->getImageId()] = $image;
    }

    /**
     * @param ImageId $imageId
     */
    public function removeImage(ImageId $imageId)
    {
        unset($this->images[(string) $imageId]);
    }

    /**
     * @return array|Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }
}
