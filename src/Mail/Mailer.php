<?php


namespace Domain\Mail;


use Domain\Mail\Transports\MailJetTransport;
use Domain\Mail\Transports\SendGridTransport;
use Domain\Mail\Transports\Transportable;
use Illuminate\Contracts\Container\Container as Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

class Mailer
{
    protected Application $app;
    protected string $current;
    protected array $mailers = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->current = $this->getDefaultDriver();
    }

    public function send(Message $message, $transport = null): self
    {
        $transport = $transport ?? $this->getDefaultDriver();
        $this->current = $transport;

        if(!array_key_exists($transport, $this->mailers)) {
            $this->mailers[$transport] = $this->createTransport($transport);
        }

        $this->mailers[$transport]->submit($message);
        return $this;
    }

    public function getDrivers(): Collection
    {
        return collect($this->getConfig()['mail.drivers'])
            ->reject(function ($item) {
                return !isset($item['active']) or $item['active'] === false;
            })->sortBy(function ($item){
                return $item['priority'];
            })->keys();
    }

    public function getDefaultDriver()
    {
        return $this->getConfig()['mail.default'];
    }

    protected function createTransport($transport): Transportable
    {
        if(!method_exists($this, $method = sprintf('setUp%sTransport', ucfirst($transport)))) {
            throw new \InvalidArgumentException(sprintf("%s: Doesn't Exist", $transport));
        }
        return $this->{$method}($this->getConfig()["mail.drivers.{$transport}"]);
    }

    protected function setUpMailjetTransport(array $config): Transportable
    {
        return new MailJetTransport();
    }

    protected function setUpSendgridTransport(array $config): Transportable
    {
        return new SendGridTransport();
    }

    protected function getConfig()
    {
        return $this->app['config'];
    }
}