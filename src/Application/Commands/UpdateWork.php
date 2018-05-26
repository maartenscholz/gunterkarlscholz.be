<?php

namespace Gks\Application\Commands;

use Gks\Domain\ValueObjects\NonZeroUnsignedInteger;
use Gks\Domain\Works\Dimensions;
use Gks\Domain\Works\Title;
use Gks\Domain\Works\Type;
use Gks\Domain\Works\WorkId;
use Psr\Http\Message\ServerRequestInterface;

class UpdateWork
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
    private $dimension;

    /**
     * @param WorkId $workId
     * @param Type $type
     * @param Title $title
     * @param Dimensions $dimension
     */
    public function __construct(WorkId $workId, Type $type, Title $title, Dimensions $dimension = null)
    {
        $this->workId = $workId;
        $this->type = $type;
        $this->title = $title;
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
        $dimension = null;

        if ($parsedBody['width'] !== '' && $parsedBody['height'] !== '') {
            $dimension = new Dimensions(
                new NonZeroUnsignedInteger((int) $parsedBody['width']),
                new NonZeroUnsignedInteger((int) $parsedBody['height'])
            );
        }

        return new static($workId, $type, $title, $dimension);
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
     * @return Dimensions|null
     */
    public function getDimension(): ?Dimensions
    {
        return $this->dimension;
    }
}
