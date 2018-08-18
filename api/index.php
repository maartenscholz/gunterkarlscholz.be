<?php

use Gks\Infrastructure\Api\Http\RoutingServiceProvider;
use Gks\Infrastructure\Http\ApplicationRequestHandler;
use Zend\HttpHandlerRunner\Emitter\EmitterInterface;
use Zend\HttpHandlerRunner\RequestHandlerRunner;

require_once __DIR__.'/../bootstrap.php';

$container->addServiceProvider(RoutingServiceProvider::class);

$runner = new RequestHandlerRunner(
    $container->get(ApplicationRequestHandler::class),
    $container->get(EmitterInterface::class),
    $container->get('ServerRequestFactory'),
    $container->get('ServerRequestErrorResponseGenerator')
);

$runner->run();
