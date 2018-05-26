<?php

namespace Gks\Domain\Model\Works;

use Gks\Domain\Model\Work;
use Gks\Domain\Works\Images\ImageId;

/**
 * @Entity
 * @Table(name="work_images")
 */
class Image
{
    /**
     * @var Work
     *
     * @ManyToOne(targetEntity="Gks\Domain\Model\Work", inversedBy="images")
     */
    private $work;

    /**
     * @var string
     *
     * @Id
     * @Column
     */
    private $id;

    /**
     * @var string
     *
     * @Column
     */
    private $filename;

    /**
     * @var string
     *
     * @Column
     */
    private $path;

    /**
     * @param Work $work
     * @param ImageId $id
     * @param string $filename
     * @param string $path
     */
    public function __construct(Work $work, ImageId $id, string $filename, string $path)
    {
        $this->work = $work;
        $this->id = (string) $id;
        $this->filename = $filename;
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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
