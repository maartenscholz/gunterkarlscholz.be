<?php

namespace Gks\Infrastructure\Persistence\MySQL;

use Doctrine\ORM\EntityManagerInterface;
use Gks\Domain\Model\Work;
use Gks\Domain\Model\Works\WorkId;
use Gks\Domain\Model\Works\WorksRepository;

class WorkRepository implements WorksRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
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
