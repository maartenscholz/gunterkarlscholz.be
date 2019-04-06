<?php

namespace Gks\Domain\Model\Works;

use Gks\Domain\Model\Work;

interface WorksRepository
{
    public function add(Work $work): void;

    public function remove(WorkId $workId): void;

    public function findById(WorkId $workId): Work;

    /**
     * @return Work[]
     */
    public function all(): array;
}
