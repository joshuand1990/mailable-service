<?php


namespace Domain\Support\Mail;

use Domain\Support\Events\EmailSending;
use Domain\Support\Events\EmailSent;
use Domain\Support\Mail\Transports\MailJetTransport;
use Domain\Support\Mail\Transports\SendGridTransport;
use Domain\Support\Mail\Transports\Transportable;
use Illuminate\Contracts\Container\Container as Application;
use Illuminate\Contracts\Events\Dispatcher;

class Mailer implements Mailerable
{
    protected Application $app;
    protected string $current;
    protected array $mailers = [];
    private ?Dispatcher $events;

    public function __construct(Application $app, Dispatcher $events = null)
    {
        $this->app = $app;
        $this->events = $events;
    }

    public function getCurrentTransport() : string
    {
        return $this->current ?? $this->getDefaultTransport();
    }

    public function send(Message $message): self
    {
        $this->setGlobalSendingAddress($message);
        if(!array_key_exists($this->getCurrentTransport(), $this->mailers)) {
            $this->mailers[$this->getCurrentTransport()] = $this->createTransport($this->getCurrentTransport());
        }
        $this->dispatchSendingMailEvent($message);
        $this->mailers[$this->getCurrentTransport()]->submit($message);
        $this->dispatchSentMailEvent($message);
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

    /**
     * @param Message $message
     */
    protected function dispatchSendingMailEvent(Message &$message): void
    {
        if(!$this->events) {
            return;
        }
        $this->events->dispatch(new EmailSending($message, $this->getCurrentTransport()));
    }

    /**
     * @param Message $message
     */
    protected function dispatchSentMailEvent(Message $message): void
    {
        if(!$this->events) {
            return;
        }
        $this->events->dispatch(new EmailSent($message, $this->getCurrentTransport()));
    }

    /**
     * @param Message $message
     */
    protected function setGlobalSendingAddress(Message &$message): self
    {
        $message->from(
            $this->getConfig()['mail.global.name'] ?? $message->getFromName(),
            $this->getConfig()['mail.global.from'] ?? $message->getFromEmail()
        );
        return $this;
    }


}