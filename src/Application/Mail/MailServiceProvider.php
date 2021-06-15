<?php


namespace Domain\Application\Mail;

use Domain\Support\Mail\AutoSwappingMailer;
use Domain\Support\Mail\Mailer;
use Domain\Support\Mail\Transports\MailJetTransport;
use Domain\Support\Mail\Transports\SendGridTransport;
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
        $this->app->singleton('mailer', function ($app) {
            return (new AutoSwappingMailer(new Mailer($app)));
        });

        $this->app->singleton(MailJetTransport::class, function () {
            $config = $this->app['config']['mail.drivers.mailjet'];
            return new MailJetTransport($config['url'], $config['apiKey'], $config['secretKey'], $config);
        });

        $this->app->singleton(SendGridTransport::class, function () {
            $config = $this->app['config']['mail.drivers.sendgrid'];
            return new SendGridTransport($config['apiKey'], $config);
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
            'mailer',
            MailJetTransport::class,
            SendGridTransport::class
        ];
    }
}