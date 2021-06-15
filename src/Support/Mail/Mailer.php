<?php


namespace Domain\Support\Mail;

use Domain\Support\Mail\Transports\MailJetTransport;
use Domain\Support\Mail\Transports\SendGridTransport;
use Domain\Support\Mail\Transports\Transportable;
use Illuminate\Contracts\Container\Container as Application;

class Mailer implements Mailerable
{
    protected Application $app;
    protected string $current;
    protected array $mailers = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getCurrentTransport() : string
    {
        return $this->current ?? $this->getDefaultTransport();
    }

    public function send(Message $message): self
    {
        if(!array_key_exists($this->getCurrentTransport(), $this->mailers)) {
            $this->mailers[$this->getCurrentTransport()] = $this->createTransport($this->getCurrentTransport());
        }
        $this->mailers[$this->getCurrentTransport()]->submit($message);
        return $this;
    }

    public function getTransports(): array
    {
        $drivers = collect($this->getConfig()['mail.drivers'])
            ->reject(function ($item) {
                return !isset($item['active']) or $item['active'] === false;
            })->sortBy(function ($item){
                return $item['priority'];
            })->keys()->toArray();
        return array_combine($drivers, $drivers);
    }

    public function getDefaultTransport(): string
    {
        return $this->getConfig()['mail.default'];
    }
    public function setCurrentTransport(string $transport): self
    {
        $this->current = $transport;
        return $this;
    }

    protected function createTransport($transport): Transportable
    {
        if(!method_exists($this, $method = sprintf('setUp%sTransport', ucfirst($transport)))) {
            throw new \InvalidArgumentException(sprintf("%s: Doesn't Exist", $transport));
        }
        return $this->{$method}();
    }

    protected function setUpMailjetTransport(): Transportable
    {
        return  app(MailJetTransport::class);
    }

    protected function setUpSendgridTransport(): Transportable
    {
        return  app(SendGridTransport::class);
    }

    protected function getConfig()
    {
        return $this->app['config'];
    }


}