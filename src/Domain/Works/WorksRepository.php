<?php

namespace Gks\Domain\Works;

interface WorksRepository
{
    /**
     * @param Work $work
     *
     * @return void
     */
    public function add(Work $work);

    /**
     * @param WorkId $workId
     *
     * @return void
     */
    public function remove(WorkId $workId);

    /**
     * @param WorkId $workId
     *
     * @return Work
     */
    public function findById(WorkId $workId);

    /**
     * @return array|Work[]
     */
    public function all();
}
