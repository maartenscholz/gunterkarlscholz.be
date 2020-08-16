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
            'host' => getenv('MYSQL_HOST'),
            'name' => getenv('MYSQL_DATABASE'),
            'user' => getenv('MYSQL_USERNAME'),
            'pass' => getenv('MYSQL_PASSWORD'),
            'port' => getenv('MYSQL_PORT'),
            'charset' => 'utf8mb4',
        ],
    ],
    'version_order' => 'creation',
];
