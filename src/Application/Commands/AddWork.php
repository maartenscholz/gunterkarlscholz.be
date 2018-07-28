<?php

namespace Gks\Application\Commands;

use Gks\Domain\Model\Works\Dimensions;
use Gks\Domain\Model\Works\Title;
use Gks\Domain\Model\Works\Type;
use Gks\Domain\Model\Works\WorkId;
use Gks\Domain\ValueObjects\NonZeroUnsignedInteger;
use Psr\Http\Message\ServerRequestInterface;

class AddWork
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
     * @var Dimensions|null
     */
    private $dimension;

    /**
     * CreateWork constructor.
     *
     * @param WorkId $workId
     * @param Type $type
     * @param Title $title
     * @param Dimensions|null $dimension
     */
    public function __construct(WorkId $workId, Type $type, Title $title, Dimensions $dimension = null)
    {
        $this->workId = $workId;
        $this->type = $type;
        $this->title = $title;
        $this->dimension = $dimension;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return AddWork
     */
    public static function fromRequest(ServerRequestInterface $request)
    {
        $parsedBody = $request->getParsedBody();

        $type = new Type($parsedBody['type']);
        $title = new Title($parsedBody['title']);
        $dimension = null;

        if ($parsedBody['width'] && $parsedBody['height']) {
            $dimension = new Dimensions(
                new NonZeroUnsignedInteger((int) $parsedBody['width']),
                new NonZeroUnsignedInteger((int) $parsedBody['height'])
            );
        }

        return new static(WorkId::generate(), $type, $title, $dimension);
    }

    /**
     * @return WorkId
     */
    public function getWorkId()
    {
        return $this->workId;
    }

    /**
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return Dimensions
     */
    public function getDimension()
    {
        return $this->dimension;
    }
}
