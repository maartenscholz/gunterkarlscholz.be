<?php

namespace Gks\Domain\Model;

use Gks\Domain\ValueObjects\NonZeroUnsignedInteger;
use Gks\Domain\Works\Dimensions;
use Gks\Domain\Works\Title;
use Gks\Domain\Works\Type;
use Gks\Domain\Works\WorkId;

/**
 * @Entity
 * @Table(name="works")
 */
class Work
{
    /**
     * @var int
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
    private $type;

    /**
     * @var Title
     *
     * @Column(name="title_nl_be")
     */
    private $titleNl;

    /**
     * @var Title
     *
     * @Column(name="title_en_us")
     */
    private $titleEn;

    /**
     * @var Title
     *
     * @Column(name="title_de_de")
     */
    private $titleDe;

    /**
     * @var Title
     *
     * @Column(name="title_fr_fr")
     */
    private $titleFr;

    /**
     * @var int
     *
     * @Column(type="integer")
     */
    private $width;

    /**
     * @var int
     *
     * @Column(type="integer")
     */
    private $height;

    /**
     * Work constructor.
     *
     * @param WorkId $id
     * @param Type $type
     * @param Title $title
     * @param Dimensions $dimensions
     */
    public function __construct(WorkId $id, Type $type, Title $title, Dimensions $dimensions)
    {
        $this->id = $id->getValue()->toString();
        $this->type = $type->getValue();
        $this->titleNl = $title->getValue('nl_BE');
        $this->titleEn = $title->getValue('en_US');
        $this->titleFr = $title->getValue('fr_FR');
        $this->titleDe = $title->getValue('de_DE');
        $this->width = $dimensions->getWidth()->getValue();
        $this->height = $dimensions->getHeight()->getValue();
    }

    /**
     * @return WorkId
     */
    public function getId(): WorkId
    {
        return WorkId::fromString($this->id);
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return new Type($this->type);
    }

    /**
     * @return Title
     */
    public function getTitle(): Title
    {
        return new Title([
            'nl_BE' => $this->titleNl,
            'en_US' => $this->titleEn,
            'fr_FR' => $this->titleFr,
            'de_DE' => $this->titleDe,
        ]);
    }

    /**
     * @return Dimensions
     */
    public function getDimensions(): Dimensions
    {
        return new Dimensions(new NonZeroUnsignedInteger($this->width), new NonZeroUnsignedInteger($this->height));
    }
}
