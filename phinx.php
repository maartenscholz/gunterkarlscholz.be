<?php

require_once __DIR__.'/bootstrap.php';

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/database/seeders'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'gks',
        'gks' => [
            'adapter' => 'mysql',
            'host' => $_ENV['MYSQL_HOST'],
            'name' => $_ENV['MYSQL_DATABASE'],
            'user' => $_ENV['MYSQL_USERNAME'],
            'pass' => $_ENV['MYSQL_PASSWORD'],
            'port' => $_ENV['MYSQL_PORT'],
            'charset' => 'utf8mb4',
        ],
    ],
    'version_order' => 'creation',
];
