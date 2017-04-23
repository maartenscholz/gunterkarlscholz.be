<?php

namespace Gks\Domain\Works\Commands;

use Gks\Infrastructure\ValueObjects\Dimension;
use Gks\Infrastructure\ValueObjects\NonZeroUnsignedInteger;
use Gks\Domain\Works\Title;
use Gks\Domain\Works\Type;
use Gks\Domain\Works\WorkId;
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
     * @var Dimension
     */
    private $dimension;

    /**
     * CreateWork constructor.
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
            $dimension = new Dimension(
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
     * @return Dimension
     */
    public function getDimension()
    {
        return $this->dimension;
    }
}
