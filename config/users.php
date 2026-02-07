<?php

return [
    'min_salary_limit' => env('USER_MIN_SALARY_LIMIT', 20000),
    'max_salary_limit' => env('USER_MAX_SALARY_LIMIT', 100000),

    'main' => [
        'name'       => env('USER_NAME', 'Test user'),
        'email'      => env('USER_EMAIL', 'example@mail.com'),
        'password'   => env('USER_PASSWORD', 'testtest'),
        'min_salary' => env('USER_MIN_SALARY', 20000),
        'max_salary' => env('USER_MAX_SALARY', 80000),
    ],
    'demo' => [
        'name'       => env('USER_DEMO_NAME', 'Demo'),
        'email'      => env('USER_DEMO_EMAIL', 'demo@example.com'),
        'password'   => env('USER_DEMO_PASSWORD', 'demo'),
        'min_salary' => env('USER_DEMO_MIN_SALARY', 20000),
        'max_salary' => env('USER_DEMO_MAX_SALARY', 80000),
    ],
];
