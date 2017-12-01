<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel CORS
     |--------------------------------------------------------------------------
     |
     | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
     | to accept any value.
     |
     */
    'supportsCredentials' => false,
    'allowedOrigins' => ['*'],
    'allowedHeaders' => ['Content-Type', 'X-Requested-With', 'Authorization'],
    'allowedMethods' => ['GET', 'POST', 'PUT', 'DELETE', 'HEAD'],
    'exposedHeaders' => [],
    'maxAge' => 0,
];

