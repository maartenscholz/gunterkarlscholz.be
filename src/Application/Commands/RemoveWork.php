<?php

namespace Gks\Application\Commands;

use Gks\Domain\Model\Works\WorkId;

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
