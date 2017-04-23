<?php

namespace Gks\Domain\Works\Commands;

use Gks\Infrastructure\ValueObjects\Dimension;
use Gks\Infrastructure\ValueObjects\NonZeroUnsignedInteger;
use Gks\Domain\Works\Title;
use Gks\Domain\Works\Type;
use Gks\Domain\Works\Work;
use Gks\Domain\Works\WorkId;
use Psr\Http\Message\ServerRequestInterface;

class UpdateWork
{
    /**
     * @var Work
     */
    private $work;

    /**
     * @param Work $work
     */
    protected function __construct(Work $work)
    {
        $this->work = $work;
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
            $dimension = new Dimension(
                new NonZeroUnsignedInteger((int) $parsedBody['width']),
                new NonZeroUnsignedInteger((int) $parsedBody['height'])
            );
        }


        return new static(new Work($workId, $type, $title, $dimension));
    }

    /**
     * @return Work
     */
    public function getWork(): Work
    {
        return $this->work;
    }
}
