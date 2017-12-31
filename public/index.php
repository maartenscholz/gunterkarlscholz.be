<?php

use Gks\Application\Providers\AppServiceProvider;
use Gks\Application\Providers\AuthServiceProvider;
use Gks\Application\Providers\ExceptionServiceProvider;
use Gks\Application\Providers\FilesystemServiceProvider;
use Gks\Application\Providers\GlideServiceProvider;
use Gks\Application\Providers\LoggingServiceProvider;
use Gks\Application\Providers\Neo4jServiceProvider;
use Gks\Application\Providers\RouteServiceProvider;
use Gks\Application\Providers\SessionServiceProvider;
use Gks\Application\Providers\TemplatingServiceProvider;
use Gks\Domain\Works\ServiceProvider as WorksServiceProvider;
use Gks\Infrastructure\CommandBus\ServiceProvider as CommandBusServiceProvider;
use League\Route\RouteCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Whoops\Run;
use Zend\Diactoros\Response\EmitterInterface;

require '../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();
$dotenv->required([
    'APP_ENV',
    'APP_ADMIN_PASSWORD',
    'NEO4J_HOST',
    'NEO4J_PORT',
    'NEO4J_USER',
    'NEO4J_PASS',
    'GLIDE_SIGNATURE_KEY',
]);

$container = new League\Container\Container;

$container->addServiceProvider(ExceptionServiceProvider::class);
$container->addServiceProvider(AuthServiceProvider::class);
$container->addServiceProvider(RouteServiceProvider::class);
$container->addServiceProvider(SessionServiceProvider::class);
$container->addServiceProvider(TemplatingServiceProvider::class);
$container->addServiceProvider(AppServiceProvider::class);
$container->addServiceProvider(Neo4jServiceProvider::class);
$container->addServiceProvider(CommandBusServiceProvider::class);
$container->addServiceProvider(WorksServiceProvider::class);
$container->addServiceProvider(GlideServiceProvider::class);
$container->addServiceProvider(FilesystemServiceProvider::class);
$container->addServiceProvider(LoggingServiceProvider::class);

$whoops = $container->get(Run::class);
$whoops->register();

/** @var RouteCollection $route */
$route = $container->get(RouteCollection::class);

$response = $route->dispatch($container->get(ServerRequestInterface::class), $container->get(ResponseInterface::class));

$container->get(EmitterInterface::class)->emit($response);
