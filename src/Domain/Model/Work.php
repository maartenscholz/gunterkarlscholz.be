<?php

namespace Gks\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gks\Domain\Model\Works\Description;
use Gks\Domain\Model\Works\Dimensions;
use Gks\Domain\Model\Works\Image;
use Gks\Domain\Model\Works\Images\ImageId;
use Gks\Domain\Model\Works\Title;
use Gks\Domain\Model\Works\Type;
use Gks\Domain\Model\Works\WorkId;
use Gks\Domain\ValueObjects\NonZeroUnsignedInteger;

/**
 * @Entity
 * @Table(name="works")
 */
class Work
{
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
    private $type;

    /**
     * @var string
     *
     * @Column(name="title_nl_be")
     */
    private $titleNl;

    /**
     * @var string
     *
     * @Column(name="title_en_us")
     */
    private $titleEn;

    /**
     * @var string
     *
     * @Column(name="title_de_de")
     */
    private $titleDe;

    /**
     * @var string
     *
     * @Column(name="title_fr_fr")
     */
    private $titleFr;

    /**
     * @var string
     *
     * @Column(name="description_nl_be")
     */
    private $descriptionNl;

    /**
     * @var string
     *
     * @Column(name="description_en_us")
     */
    private $descriptionEn;

    /**
     * @var string
     *
     * @Column(name="description_de_de")
     */
    private $descriptionDe;

    /**
     * @var string
     *
     * @Column(name="description_fr_fr")
     */
    private $descriptionFr;

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
     * @var Image[]|Collection
     *
     * @OneToMany(
     *     targetEntity="Gks\Domain\Model\Works\Image",
     *     mappedBy="work",
     *     cascade={"persist"},
     *     orphanRemoval=true,
     *     indexBy="id"
     * )
     */
    private $images;

    public function __construct(
        WorkId $id,
        Type $type,
        Title $title,
        Description $description,
        Dimensions $dimensions = null
    ) {
        $this->id = $id->getValue()->toString();
        $this->type = $type->getValue();
        $this->titleNl = $title->getValue('nl_BE');
        $this->titleEn = $title->getValue('en_US');
        $this->titleFr = $title->getValue('fr_FR');
        $this->titleDe = $title->getValue('de_DE');
        $this->descriptionNl = $description->getValue('nl_BE');
        $this->descriptionEn = $description->getValue('en_US');
        $this->descriptionFr = $description->getValue('fr_FR');
        $this->descriptionDe = $description->getValue('de_DE');
        $this->width = $dimensions ? $dimensions->getWidth()->getValue() : null;
        $this->height = $dimensions ? $dimensions->getHeight()->getValue() : null;
        $this->images = new ArrayCollection();
    }

    public function update(Type $type, Title $title, Description $description, Dimensions $dimensions = null): void
    {
        $this->type = $type->getValue();
        $this->titleNl = $title->getValue('nl_BE');
        $this->titleEn = $title->getValue('en_US');
        $this->titleFr = $title->getValue('fr_FR');
        $this->titleDe = $title->getValue('de_DE');
        $this->descriptionNl = $description->getValue('nl_BE');
        $this->descriptionEn = $description->getValue('en_US');
        $this->descriptionFr = $description->getValue('fr_FR');
        $this->descriptionDe = $description->getValue('de_DE');
        $this->width = $dimensions ? $dimensions->getWidth()->getValue() : null;
        $this->height = $dimensions ? $dimensions->getHeight()->getValue() : null;
    }

    public function addImage(ImageId $imageId, string $filename, string $path): void
    {
        $this->images->set((string) $imageId, new Image($this, $imageId, $filename, $path));
    }

    public function removeImage(ImageId $imageId)
    {
        $this->images->remove((string) $imageId);
    }

    public function getId(): WorkId
    {
        return WorkId::fromString($this->id);
    }

    public function getType(): Type
    {
        return new Type($this->type);
    }

    public function getTitle(): Title
    {
        return new Title(
            [
                'nl_BE' => $this->titleNl,
                'en_US' => $this->titleEn,
                'fr_FR' => $this->titleFr,
                'de_DE' => $this->titleDe,
            ]
        );
    }

    public function getDescription(): Description
    {
        return new Description(
            [
                'nl_BE' => $this->descriptionNl,
                'en_US' => $this->descriptionEn,
                'fr_FR' => $this->descriptionFr,
                'de_DE' => $this->descriptionDe,
            ]
        );
    }

    public function getDimensions(): ?Dimensions
    {
        if ($this->width && $this->height) {
            return new Dimensions(new NonZeroUnsignedInteger($this->width), new NonZeroUnsignedInteger($this->height));
        }

        return null;
    }

    /**
     * @return Image[]
     */
    public function getImages(): array
    {
        return $this->images->toArray();
    }

    public function getImage(ImageId $imageId): Image
    {
        return $this->images->get((string) $imageId);
    }
}
