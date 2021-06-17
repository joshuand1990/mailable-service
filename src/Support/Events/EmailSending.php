<?php


namespace Domain\Support\Events;


use Domain\Support\Mail\Messageable;

class EmailSending
{
    public Messageable $message;
    public string $transport;

    /**
     * EmailSending constructor.
     */
    public function __construct(Messageable $message, string $transport)
    {
        $this->message = $message;
        $this->transport = $transport;
    }
}