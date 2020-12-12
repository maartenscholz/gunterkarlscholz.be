<?php

namespace Gks\Infrastructure\Logging;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Sentry\ClientBuilder;
use Sentry\Monolog\Handler;
use Sentry\SentrySdk;
use Sentry\State\Hub;
use Sentry\State\HubInterface;

final class ServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        LoggerInterface::class,
        HubInterface::class,
    ];

    public function register(): void
    {
        $this->leagueContainer->share(
            LoggerInterface::class,
            function () {
                $log = new Logger('main');

                $log->pushHandler(new RotatingFileHandler(realpath(__DIR__.'/../../../storage/logs').'/error.log', 5));

                if ($_ENV['APP_ENV'] === 'production') {
                    $log->pushHandler(new Handler($this->container->get(HubInterface::class)));
                }

                return $log;
            }
        );

        $this->leagueContainer->share(
            HubInterface::class,
            static function () {
                $client = ClientBuilder::create(
                    [
                        'dsn' => $_ENV['SENTRY_DSN'],
                        'environment' => $_ENV['APP_ENV'],
                    ]
                )->getClient();

                $hub = new Hub($client);

                SentrySdk::setCurrentHub($hub);

                return $hub;
            }
        );
    }
}
