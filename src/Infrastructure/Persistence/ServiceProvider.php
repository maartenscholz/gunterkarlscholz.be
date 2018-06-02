<?php

namespace Gks\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use Gks\Domain\Model\Works\WorksRepository;
use Gks\Infrastructure\Persistence\MySQL\WorkRepository;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        WorksRepository::class,
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
            return new WorkRepository($this->container->get(EntityManagerInterface::class));
        });
    }
}
