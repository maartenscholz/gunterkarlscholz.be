<?php

use Gks\Infrastructure\Api\Http\RoutingServiceProvider;
use League\Route\Router;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmitterInterface;

require_once __DIR__.'/../bootstrap.php';

$container->addServiceProvider(RoutingServiceProvider::class);

/** @var Router $route */
$route = $container->get(Router::class);

$response = $route->dispatch($container->get(ServerRequestInterface::class));

$container->get(EmitterInterface::class)->emit($response);
