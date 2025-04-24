<?php

return [
    'paths' => [
        'api/*', 
        'sanctum/csrf-cookie',
        'login', 
        'logout',
        'register'  // Si tienes ruta de registro
    ],

    'allowed_methods' => ['*'],  // GET, POST, PUT, DELETE, etc.

    // En desarrollo:
    'allowed_origins' => ['*'],  // Permite cualquier dominio (¡solo para dev!)

    // En producción (reemplaza con tus dominios Flutter):
    // 'allowed_origins' => [
    //     'http://localhost:8080',  // Android emulador
    //     'http://192.168.1.X:8080', // IP local para dispositivos físicos
    //     'https://tuaplicacion.com' // Dominio en producción
    // ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],  // Content-Type, Authorization, etc.

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,  // Si usas cookies, cámbialo a `true`
];