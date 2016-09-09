<?php

return [
    'settings' => [

        'displayErrorDetails' => true,

        'twig' => [
            'cache' => false,
        ],

        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'inventarios',
            'username' => 'invuser',
            'password' => 'invpass',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ],
    ],
];
