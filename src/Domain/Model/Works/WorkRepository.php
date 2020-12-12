<?php

namespace Gks\Domain\Model\Works;

use Gks\Domain\Model\Work;

interface WorkRepository
{
    public function add(Work $work): void;

    public function remove(WorkId $workId): void;

    public function findById(WorkId $workId): Work;

    public function findBySlug(string $slug): Work;

    /**
     * @return Work[]
     */
    public function all(): array;
}
