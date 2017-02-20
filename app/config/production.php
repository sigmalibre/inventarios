<?php
/**
 * Contiene la lista con las configuraciones que estarán disponibles dentro del contenedor de Slim.
 */

return [
    'settings' => [

        'displayErrorDetails' => false,

        'twig' => [
            'cache' => false,
            'debug' => false,
        ],

        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'id303121_inventario',
            'username' => 'id303121_invuser',
            'password' => 'invpass',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ],
    ],
];
