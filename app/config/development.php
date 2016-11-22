<?php

return [
    'settings' => [

        'displayErrorDetails' => true,

        'twig' => [
            'cache' => false,
            'debug' => true,
        ],

        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'inventario',
            'username' => 'invuser',
            'password' => 'invpass',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ],
    ],
];
