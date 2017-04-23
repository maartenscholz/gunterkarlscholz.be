<?php

namespace Gks\Domain\Works;

use Gks\Infrastructure\ValueObjects\Dimension;
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
     * @var Dimension
     */
    private $dimension;

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
     * @param Dimension $dimension
     */
    public function __construct(WorkId $workId, Type $type, Title $title, Dimension $dimension = null)
    {
        $this->workId = $workId;
        $this->type = $type;
        $this->title = $title;
        $this->dimension = $dimension;
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
     * @return Dimension
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * @param Image $image
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;
    }

    /**
     * @return array|Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }
}
