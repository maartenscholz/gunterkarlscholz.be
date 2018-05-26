<?php

namespace Gks\Infrastructure\Persistence\MySQL;

use Doctrine\ORM\EntityManager;
use Gks\Domain\Model\Work;
use Gks\Domain\Works\WorkId;
use Gks\Domain\Works\WorksRepository;

class WorkRepository implements WorksRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Work $work
     *
     * @return void
     */
    public function add(Work $work)
    {
        $this->entityManager->persist($work);
        $this->entityManager->flush();
    }

    /**
     * @param WorkId $workId
     *
     * @return void
     */
    public function remove(WorkId $workId)
    {
        $workReference = $this->entityManager->getReference(Work::class, $workId);

        $this->entityManager->remove($workReference);
        $this->entityManager->flush();
    }

    /**
     * @param WorkId $workId
     *
     * @return Work
     */
    public function findById(WorkId $workId)
    {
        return $this->entityManager->getRepository(Work::class)->find($workId);
    }

    /**
     * @return array|Work[]
     */
    public function all()
    {
        return $this->entityManager->getRepository(Work::class)->findAll();
    }
}
