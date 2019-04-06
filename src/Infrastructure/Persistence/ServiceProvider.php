<?php

namespace Gks\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use Gks\Domain\Model\Works\WorksRepository;
use Gks\Infrastructure\Persistence\MySQL\WorkRepository;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var Container
     */
    protected $container;

    protected $provides = [
        WorksRepository::class,
    ];

    public function register(): void
    {
        $this->container->share(WorksRepository::class, function () {
            return new WorkRepository($this->container->get(EntityManagerInterface::class));
        });
    }
}
