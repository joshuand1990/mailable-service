<?php

namespace App\Providers;

use Domain\Application\Listeners\EmailSendingListener;
use Domain\Application\Listeners\EmailSentListener;
use Domain\Support\Events\EmailSending;
use Domain\Support\Events\EmailSent;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        EmailSending::class => [
            EmailSendingListener::class
        ],
        EmailSent::class => [
            EmailSentListener::class
        ],
        EmailError::class => [

        ]
    ];
}
