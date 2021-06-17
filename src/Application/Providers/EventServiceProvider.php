<?php


namespace Domain\Application\Providers;


use Domain\Application\Listeners\EmailSendingListener;
use Domain\Application\Listeners\EmailSentListener;
use Domain\Support\Events\EmailSending;
use Domain\Support\Events\EmailSendingError;
use Domain\Support\Events\EmailSent;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        EmailSending::class => [
            EmailSendingListener::class
        ],
        EmailSent::class => [
            EmailSentListener::class
        ],
        EmailSendingError::class => [

        ]
    ];
}