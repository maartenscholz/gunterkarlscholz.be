<?php

declare(strict_types=1);

use Gks\Infrastructure\Api\Http\ServiceProvider;
use Gks\Infrastructure\Http\ApplicationRequestHandler;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;

require_once __DIR__.'/../bootstrap.php';

$container->addServiceProvider(ServiceProvider::class);

$runner = new RequestHandlerRunner(
    $container->get(ApplicationRequestHandler::class),
    $container->get(EmitterInterface::class),
    $container->get('ServerRequestFactory'),
    $container->get('ServerRequestErrorResponseGenerator')
);

$runner->run();
