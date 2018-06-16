<?php

use Gks\Infrastructure\UserInterface\Http\RouteServiceProvider;
use League\Route\RouteCollection;
use Predis\Session\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Whoops\Run;
use Zend\Diactoros\Response\EmitterInterface;

require_once __DIR__.'/../bootstrap.php';

$container->addServiceProvider(RouteServiceProvider::class);

$redisSessionHandler = $container->get(Handler::class);
$redisSessionHandler->register();

$whoops = $container->get(Run::class);
$whoops->register();

/** @var RouteCollection $route */
$route = $container->get(RouteCollection::class);

$response = $route->dispatch($container->get(ServerRequestInterface::class), $container->get(ResponseInterface::class));

$container->get(EmitterInterface::class)->emit($response);
