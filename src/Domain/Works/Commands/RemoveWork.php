<?php

namespace Gks\Domain\Works\Commands;

use Gks\Domain\Works\WorkId;

class RemoveWork
{
    /**
     * @var WorkId
     */
    private $workId;

    /**
     * RemoveWork constructor.
     *
     * @param WorkId $workId
     */
    public function __construct(WorkId $workId)
    {
        $this->workId = $workId;
    }

    /**
     * @return WorkId
     */
    public function getWorkId()
    {
        return $this->workId;
    }
}
