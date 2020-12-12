<?php

namespace Gks\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use Gks\Domain\Model\Works\WorkRepository;
use Gks\Infrastructure\Persistence\MySQL\DoctrineWorkRepository;
use League\Container\ServiceProvider\AbstractServiceProvider;

final class ServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        WorkRepository::class,
    ];

    public function register(): void
    {
        $this->leagueContainer->share(
            WorkRepository::class,
            function () {
                return new DoctrineWorkRepository($this->container->get(EntityManagerInterface::class));
            }
        );
    }
}
