<?php

return [
    'main' => [
        'name'     => env('USER_NAME', 'Test user'),
        'email'    => env('USER_EMAIL', 'example@mail.com'),
        'password' => env('USER_PASSWORD', 'testtest'),
    ],
    'demo' => [
        'name'     => env('USER_DEMO_NAME', 'Demo'),
        'email'    => env('USER_DEMO_EMAIL', 'demo@example.com'),
        'password' => env('USER_DEMO_PASSWORD', 'demo'),
    ],
];
