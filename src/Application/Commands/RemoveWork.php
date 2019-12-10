<?php

namespace Gks\Application\Commands;

use Gks\Domain\Model\Works\WorkId;

final class RemoveWork
{
    private WorkId $workId;

    public function __construct(WorkId $workId)
    {
        $this->workId = $workId;
    }

    public function getWorkId(): WorkId
    {
        return $this->workId;
    }
}
