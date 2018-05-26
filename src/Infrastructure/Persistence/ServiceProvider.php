<?php

namespace Gks\Infrastructure\Persistence;

use Doctrine\ORM\EntityManager;
use Gks\Domain\Model\Works\WorksRepository;
use Gks\Domain\Works\Images\ImageRepository;
use Gks\Infrastructure\Persistence\MySQL\WorkRepository;
use Gks\Infrastructure\Persistence\Neo4j\Neo4jImageRepository;
use GraphAware\Neo4j\Client\Client;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        WorksRepository::class,
        ImageRepository::class,
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $this->container->share(WorksRepository::class, function () {
            return new WorkRepository($this->container->get(EntityManager::class));
        });

        $this->container->share(ImageRepository::class, function () {
            return new Neo4jImageRepository($this->container->get(Client::class));
        });
    }
}
