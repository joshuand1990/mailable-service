<?php


namespace Domain\Support\Events;

use Domain\Support\Mail\Messageable;

class EmailSent
{
    public Messageable $message;
    public string $transport;

    /**
     * EmailSent constructor.
     */
    public function __construct(Messageable $message, string $transport)
    {
        $this->message = $message;
        $this->transport = $transport;
    }
}