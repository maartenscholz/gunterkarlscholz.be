<?php

namespace Gks\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use Gks\Domain\Model\Works\WorksRepository;
use Gks\Infrastructure\Persistence\MySQL\WorkRepository;
use League\Container\ServiceProvider\AbstractServiceProvider;

final class ServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        WorksRepository::class,
    ];

    public function register(): void
    {
        $this->leagueContainer->share(
            WorksRepository::class,
            function () {
                return new WorkRepository($this->container->get(EntityManagerInterface::class));
            }
        );
    }
}
