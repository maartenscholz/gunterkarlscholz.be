<?php

use Gks\Application;
use Gks\Infrastructure;

require __DIR__.'/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
$dotenv->required(
    [
        'APP_ENV',
        'APP_ADMIN_PASSWORD',
        'GLIDE_SIGNATURE_KEY',
        'SENTRY_DSN',
        'REDIS_HOST',
    ]
);

$container = new League\Container\Container();

$container->addServiceProvider(Application\CommandBus\ServiceProvider::class);
$container->addServiceProvider(Application\Handlers\ServiceProvider::class);
$container->addServiceProvider(Infrastructure\UserInterface\Http\ErrorHandling\ServiceProvider::class);
$container->addServiceProvider(Infrastructure\UserInterface\Http\SessionServiceProvider::class);
$container->addServiceProvider(Infrastructure\UserInterface\Http\TemplatingServiceProvider::class);
$container->addServiceProvider(Infrastructure\UserInterface\Http\GlideServiceProvider::class);
$container->addServiceProvider(Infrastructure\UserInterface\Http\ServiceProvider::class);
$container->addServiceProvider(Infrastructure\Persistence\ServiceProvider::class);
$container->addServiceProvider(Infrastructure\Persistence\MySQL\ServiceProvider::class);
$container->addServiceProvider(Infrastructure\Filesystem\ServiceProvider::class);
$container->addServiceProvider(Infrastructure\Logging\ServiceProvider::class);
$container->addServiceProvider(Infrastructure\Caching\Redis\ServiceProvider::class);
$container->addServiceProvider(Infrastructure\Http\ServiceProvider::class);
$container->addServiceProvider(Infrastructure\Events\ServiceProvider::class);
