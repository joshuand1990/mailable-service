<?php

return [
    'default' => env('MAIL_DRIVER', 'mailjet'),
    'drivers' => [
        'mailjet' => [
            'priority' => 1,
            'active' => true
        ],
        'sendgrid' => [
            'priority' => 2,
            'active' => true
        ]
    ]
];