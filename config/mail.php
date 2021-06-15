<?php

return [
    'default' => env('MAIL_DRIVER', 'mailjet'),
    'drivers' => [
        'mailjet' => [
            'priority' => 1,
            'active' => true,
            'url' => env('MAILJET_URL', null),
            'apiKey' => env('MAILJET_API_KEY'),
            'secretKey' => env('MAILJET_SECRET_KEY')
        ],
        'sendgrid' => [
            'priority' => 2,
            'active' => true,
            'url' => env('SENDGRID_URL', 'https://google.com')
        ]
    ]
];