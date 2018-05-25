<?php

namespace Gks\Infrastructure\Caching\Redis;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Predis\Client;
use Predis\ClientInterface;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        ClientInterface::class,
    ];

    /**
     * @return void
     */
    public function register()
    {
        $this->container->share(ClientInterface::class, function () {
            return new Client([
                'host' => getenv('PREDIS_HOST'),
            ]);
        });
    }
}
