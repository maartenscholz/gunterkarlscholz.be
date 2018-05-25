<?php

use League\Route\RouteCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmitterInterface;

require_once __DIR__.'/../bootstrap.php';

/** @var RouteCollection $route */
$route = $container->get(RouteCollection::class);

$response = $route->dispatch($container->get(ServerRequestInterface::class), $container->get(ResponseInterface::class));

$container->get(EmitterInterface::class)->emit($response);
