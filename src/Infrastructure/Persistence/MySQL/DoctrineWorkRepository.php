<?php

namespace Gks\Infrastructure\Persistence\MySQL;

use Doctrine\ORM\EntityManagerInterface;
use Gks\Domain\Model\Work;
use Gks\Domain\Model\Works\WorkId;
use Gks\Domain\Model\Works\WorkRepository;

final class DoctrineWorkRepository implements WorkRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(Work $work): void
    {
        $this->entityManager->persist($work);
        $this->entityManager->flush();
    }

    public function remove(WorkId $workId): void
    {
        $workReference = $this->entityManager->getReference(Work::class, $workId->getValue());

        $this->entityManager->remove($workReference);
        $this->entityManager->flush();
    }

    public function findById(WorkId $workId): Work
    {
        return $this->entityManager->getRepository(Work::class)->find($workId->getValue());
    }

    public function findBySlug(string $slug): Work
    {
        return $this->entityManager->getRepository(Work::class)->findOneBy(['slug' => $slug]);
    }

    /**
     * @return Work[]
     */
    public function all(): array
    {
        return $this->entityManager->getRepository(Work::class)->findBy([], ['titleNl' => 'ASC']);
    }
}
