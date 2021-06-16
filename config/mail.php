<?php

return [
    'global' => [
        'from' => env('MAIL_GLOBAL_FROM'),
        'name' => env('MAIL_GLOBAL_NAME')
    ],
    'default' => env('MAIL_DRIVER', 'mailjet'),
    'drivers' => [
        'mailjet' => [
            'priority' => 1,
            'active' => true,
            'url' => env('MAILJET_URL'),
            'apiKey' => env('MAILJET_API_KEY'),
            'secretKey' => env('MAILJET_SECRET_KEY')
        ],
        'sendgrid' => [
            'priority' => 2,
            'active' => true,
            'url' => env('SENDGRID_URL'),
            'apiKey' => env('SENDGRID_API_KEY')
        ]
    ]
];