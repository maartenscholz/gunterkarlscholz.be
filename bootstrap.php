<?php

use Gks\Application;
use Gks\Application\Handlers\ServiceProvider as CommandHandlerServiceProvider;
use Gks\Infrastructure;
use Gks\Infrastructure\Caching\Redis\ServiceProvider as RedisServiceProvider;
use Gks\Infrastructure\CommandBus\ServiceProvider as CommandBusServiceProvider;
use Gks\Infrastructure\Filesystem\ServiceProvider as FilesystemServiceProvider;
use Gks\Infrastructure\Http\ServiceProvider as HttpServiceProvider;
use Gks\Infrastructure\Logging\ServiceProvider;
use Gks\Infrastructure\Persistence\MySQL\ServiceProvider as MySQLServiceProvider;
use Gks\Infrastructure\Persistence\ServiceProvider as PersistenceServiceProvider;
use Gks\Infrastructure\UserInterface\Http\ErrorHandling\ServiceProvider as ErrorHandlingServiceProvider;
use Gks\Infrastructure\UserInterface\Http\GlideServiceProvider;
use Gks\Infrastructure\UserInterface\Http\ServiceProvider as HTTPUserInterfaceServiceProvider;
use Gks\Infrastructure\UserInterface\Http\SessionServiceProvider;
use Gks\Infrastructure\UserInterface\Http\TemplatingServiceProvider;

require __DIR__.'/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
$dotenv->required([
    'APP_ENV',
    'APP_ADMIN_PASSWORD',
    'GLIDE_SIGNATURE_KEY',
    'SENTRY_DSN',
    'REDIS_HOST',
]);

$container = new League\Container\Container;

$container->addServiceProvider(ErrorHandlingServiceProvider::class);
$container->addServiceProvider(SessionServiceProvider::class);
$container->addServiceProvider(TemplatingServiceProvider::class);
$container->addServiceProvider(CommandBusServiceProvider::class);
$container->addServiceProvider(PersistenceServiceProvider::class);
$container->addServiceProvider(GlideServiceProvider::class);
$container->addServiceProvider(FilesystemServiceProvider::class);
$container->addServiceProvider(ServiceProvider::class);
$container->addServiceProvider(CommandHandlerServiceProvider::class);
$container->addServiceProvider(HTTPUserInterfaceServiceProvider::class);
$container->addServiceProvider(RedisServiceProvider::class);
$container->addServiceProvider(MySQLServiceProvider::class);
$container->addServiceProvider(HttpServiceProvider::class);
$container->addServiceProvider(Infrastructure\Events\ServiceProvider::class);
