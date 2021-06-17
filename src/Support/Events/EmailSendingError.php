<?php


namespace Domain\Support\Events;


use Domain\Support\Mail\Messageable;

class EmailSendingError
{
    public Messageable $message;
    public string $transport;

    /**
     * EmailSendingError constructor.
     */
    public function __construct(Messageable $message, string $transport)
    {
        $this->message = $message;
        $this->transport = $transport;
    }
}