<?php


namespace Domain\Mail;

use Illuminate\Contracts\Mail\Factory ;

class MailManager implements Factory
{
     /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * MailManager constructor.
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    protected function getConfig()
    {
        return $this->app['config'];
    }
    public function mailer($name = null)
    {
        $mailer = new Mailer();
        if($this->app->bound('queue')) {
            $mailer->setQueue();
        }

        dd();
    }

    public function getMailDrivers()
    {
        return $this->getConfig()['mail.drivers'];
    }
}