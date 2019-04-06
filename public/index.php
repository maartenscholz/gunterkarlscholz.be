<?php

declare(strict_types=1);

use Gks\Infrastructure\Http\ApplicationRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RouteServiceProvider;
use Predis\Session\Handler;
use Whoops\Run;
use Zend\HttpHandlerRunner\Emitter\EmitterInterface;
use Zend\HttpHandlerRunner\RequestHandlerRunner;

require_once __DIR__.'/../bootstrap.php';

$container->addServiceProvider(RouteServiceProvider::class);

$redisSessionHandler = $container->get(Handler::class);
$redisSessionHandler->register();

$whoops = $container->get(Run::class);
$whoops->register();

$runner = new RequestHandlerRunner(
    $container->get(ApplicationRequestHandler::class),
    $container->get(EmitterInterface::class),
    $container->get('ServerRequestFactory'),
    $container->get('ServerRequestErrorResponseGenerator')
);

$runner->run();
