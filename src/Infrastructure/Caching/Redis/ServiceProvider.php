<?php

namespace Gks\Infrastructure\Caching\Redis;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Predis\Client;
use Predis\ClientInterface;
use Predis\Session\Handler;

final class ServiceProvider extends AbstractServiceProvider
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
    public function register(): void
    {
        $this->leagueContainer->share(
            ClientInterface::class,
            static function () {
                return new Client(
                    [
                        'host' => $_ENV['REDIS_HOST'],
                    ]
                );
            }
        );

        $this->leagueContainer->share(
            Handler::class,
            static function () {
                $client = new Client(
                    [
                        'host' => $_ENV['REDIS_HOST'],
                        'database' => 1,
                    ], [
                        'prefix' => 'session:',
                    ]
                );

                return new Handler(
                    $client, [
                        'gc_maxlifetime' => 604800, // one week
                    ]
                );
            }
        );
    }
}
