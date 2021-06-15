<?php


namespace Domain\Mail;

use Domain\Mail\Transports\MailJetTransport;
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
            return new Mailer($app);
        });

        $this->app->singleton(MailJetTransport::class, function() {
            $config = $this->app['config']['mail.drivers.mailjet'];
            return new MailJetTransport($config['url'], $config['apiKey'], $config['secretKey'], $config);
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