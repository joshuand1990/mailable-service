<?php


namespace Domain\Mail;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider  extends ServiceProvider implements DeferrableProvider
{
 /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('mailer', function ($app) {
            return new Mailer();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'mailer'
        ];
    }
}