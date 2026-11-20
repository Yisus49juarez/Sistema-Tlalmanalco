<?php

return [

   'paths' => ['api/*', 'sanctum/csrf-cookie', '/'],

    'allowed_methods' => ['*'],

    'allowed_origins' => array_filter([
        env('FRONTEND_URL', 'http://localhost:8001'),
        'http://localhost:8001',
        'http://127.0.0.1:8001',
    ]),

    'allowed_headers' => ['*'],

    'supports_credentials' => true,

];
