<?php

namespace Gks\Infrastructure\Caching\Redis;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Predis\Client;
use Predis\ClientInterface;
use Predis\Session\Handler;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        ClientInterface::class,
        Handler::class,
    ];

    /**
     * @return void
     */
    public function register()
    {
        $this->container->share(ClientInterface::class, function () {
            return new Client([
                'host' => getenv('REDIS_HOST'),
            ]);
        });

        $this->container->share(Handler::class, function () {
            $client = new Client([
                'host' => getenv('REDIS_HOST'),
                'database' => 1,
            ], [
                'prefix' => 'session:',
            ]);

            return new Handler($client, [
                'gc_maxlifetime' => 604800, // one week
            ]);
        });
    }
}
