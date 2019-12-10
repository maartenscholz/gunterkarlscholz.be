<?php

namespace Gks\Domain\Model\Works;

use Gks\Domain\Model\Work;
use Gks\Domain\Model\Works\Images\ImageId;

/**
 * @Entity
 * @Table(name="work_images")
 */
class Image
{
    /**
     * @ManyToOne(targetEntity="Gks\Domain\Model\Work", inversedBy="images")
     */
    private Work $work;

    /**
     * @Id
     * @Column
     */
    private string $id;

    /**
     * @Column
     */
    private string $filename;

    /**
     * @Column
     */
    private string $path;

    public function __construct(Work $work, ImageId $id, string $filename, string $path)
    {
        $this->work = $work;
        $this->id = (string) $id;
        $this->filename = $filename;
        $this->path = $path;
    }

    public function getId(): ImageId
    {
        return ImageId::fromString($this->id);
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
