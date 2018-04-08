<?php

use Gks\Application\Handlers\ServiceProvider as CommandHandlerServiceProvider;
use Gks\Infrastructure\CommandBus\ServiceProvider as CommandBusServiceProvider;
use Gks\Infrastructure\Filesystem\ServiceProvider as FilesystemServiceProvider;
use Gks\Infrastructure\Logging\ServiceProvider;
use Gks\Infrastructure\Persistence\Neo4j\ServiceProvider as Neo4jServiceProvider;
use Gks\Infrastructure\Persistence\ServiceProvider as PersistenceServiceProvider;
use Gks\Infrastructure\UserInterface\Http\ErrorHandling\ServiceProvider as ErrorHandlingServiceProvider;
use Gks\Infrastructure\UserInterface\Http\GlideServiceProvider;
use Gks\Infrastructure\UserInterface\Http\RouteServiceProvider;
use Gks\Infrastructure\UserInterface\Http\ServiceProvider as HTTPUserInterfaceServiceProvider;
use Gks\Infrastructure\UserInterface\Http\SessionServiceProvider;
use Gks\Infrastructure\UserInterface\Http\TemplatingServiceProvider;
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

$container->addServiceProvider(ErrorHandlingServiceProvider::class);
$container->addServiceProvider(RouteServiceProvider::class);
$container->addServiceProvider(SessionServiceProvider::class);
$container->addServiceProvider(TemplatingServiceProvider::class);
$container->addServiceProvider(Neo4jServiceProvider::class);
$container->addServiceProvider(CommandBusServiceProvider::class);
$container->addServiceProvider(PersistenceServiceProvider::class);
$container->addServiceProvider(GlideServiceProvider::class);
$container->addServiceProvider(FilesystemServiceProvider::class);
$container->addServiceProvider(ServiceProvider::class);
$container->addServiceProvider(CommandHandlerServiceProvider::class);
$container->addServiceProvider(HTTPUserInterfaceServiceProvider::class);

$whoops = $container->get(Run::class);
$whoops->register();

/** @var RouteCollection $route */
$route = $container->get(RouteCollection::class);

$response = $route->dispatch($container->get(ServerRequestInterface::class), $container->get(ResponseInterface::class));

$container->get(EmitterInterface::class)->emit($response);
