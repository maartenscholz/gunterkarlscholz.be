<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__.'/bootstrap.php';

/** @var EntityManager $entityManager */
$entityManager = $container->get(EntityManager::class);

return ConsoleRunner::createHelperSet($entityManager);
