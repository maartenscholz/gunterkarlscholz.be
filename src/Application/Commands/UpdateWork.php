<?php

namespace Gks\Application\Commands;

use Gks\Domain\Model\Works\Description;
use Gks\Domain\Model\Works\Dimensions;
use Gks\Domain\Model\Works\Title;
use Gks\Domain\Model\Works\Type;
use Gks\Domain\Model\Works\WorkId;
use Gks\Domain\ValueObjects\NonZeroUnsignedInteger;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateWork
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
     * @var Description
     */
    private $description;

    /**
     * @var Dimensions|null
     */
    private $dimension;

    public function __construct(WorkId $workId, Type $type, Title $title, Description $description, Dimensions $dimension = null)
    {
        $this->workId = $workId;
        $this->type = $type;
        $this->title = $title;
        $this->description = $description;
        $this->dimension = $dimension;
    }

    /**
     * @param WorkId $workId
     * @param ServerRequestInterface $request
     *
     * @return UpdateWork
     */
    public static function fromRequest(WorkId $workId, ServerRequestInterface $request)
    {
        $parsedBody = $request->getParsedBody();

        $type = new Type($parsedBody['type']);
        $title = new Title($parsedBody['title']);
        $description = new Description($parsedBody['description']);
        $dimension = null;

        if ($parsedBody['width'] !== '' && $parsedBody['height'] !== '') {
            $dimension = new Dimensions(
                new NonZeroUnsignedInteger((int) $parsedBody['width']),
                new NonZeroUnsignedInteger((int) $parsedBody['height'])
            );
        }

        return new static($workId, $type, $title, $description, $dimension);
    }

    public function getWorkId(): WorkId
    {
        return $this->workId;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function getDimension(): ?Dimensions
    {
        return $this->dimension;
    }
}
