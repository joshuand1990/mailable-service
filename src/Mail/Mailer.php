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
        $this->current = $this->getDefaultTransport();
    }

    public function getCurrentTransport() : string
    {
        return $this->current;
    }
    public function send(Message $message, $usedTransports = []): self
    {
        $transport = $transport ?? $this->getCurrentTransport();
        $this->current = $transport;

        if(!array_key_exists($transport, $this->mailers)) {
            $this->mailers[$transport] = $this->createTransport($transport);
        }

        $this->mailers[$transport]->submit($message);
        return $this;
    }

    public function getDrivers(): array
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

    public function getNextTransport($userTransports = [])
    {

    }
}