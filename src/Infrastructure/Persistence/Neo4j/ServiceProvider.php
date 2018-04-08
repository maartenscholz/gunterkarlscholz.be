<?php

namespace Gks\Infrastructure\Persistence\Neo4j;

use GraphAware\Neo4j\Client\Client;
use GraphAware\Neo4j\Client\ClientBuilder;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Client::class,
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
        $this->container->share(Client::class, function () {
            $host = getenv('NEO4J_HOST');
            $port = getenv('NEO4J_PORT');
            $user = getenv('NEO4J_USER');
            $password = getenv('NEO4J_PASS');

            return ClientBuilder::create()
                ->addConnection('default', "http://$user:$password@$host:$port")
                ->build();
        });
    }
}
