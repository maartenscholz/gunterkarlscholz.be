<?php

namespace Gks\Domain\Works;

use Gks\Domain\Works\Handlers\UpdateWork;
use Gks\Domain\Works\Handlers\AddWork;
use Gks\Domain\Works\Handlers\RemoveWork;
use GraphAware\Neo4j\Client\Client;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        WorksRepository::class,
        AddWork::class,
        UpdateWork::class,
        RemoveWork::class,
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

        $this->container->share(AddWork::class, function () {
            return new AddWork($this->container->get(WorksRepository::class));
        });

        $this->container->share(UpdateWork::class, function () {
            return new UpdateWork($this->container->get(WorksRepository::class));
        });

        $this->container->share(RemoveWork::class, function () {
            return new RemoveWork($this->container->get(WorksRepository::class));
        });
    }
}
