<?php

namespace Gks\Infrastructure\Persistence;

use Gks\Domain\Works\Images\ImageRepository;
use Gks\Domain\Works\WorksRepository;
use Gks\Infrastructure\Persistence\Neo4j\Neo4jImageRepository;
use Gks\Infrastructure\Persistence\Neo4j\Neo4jWorksRepository;
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
            return new Neo4jWorksRepository($this->container->get(Client::class));
        });

        $this->container->share(ImageRepository::class, function () {
            return new Neo4jImageRepository($this->container->get(Client::class));
        });
    }
}