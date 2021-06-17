<?php


namespace Domain\Support\Events;


use Domain\Support\Mail\Messageable;

abstract class BaseEmailEvent implements EmailEventable
{
    protected Messageable $message;
    protected string $transport;

    public function __construct(Messageable $message, string $transport)
    {
        $this->message = $message;
        $this->transport = $transport;
    }

    public function getMessage(): Messageable
    {
        return $this->message;
    }

    public function getTransport(): string
    {
        return $this->transport;
    }
}