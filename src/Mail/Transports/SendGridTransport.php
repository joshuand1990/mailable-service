<?php


namespace Domain\Mail\Transports;


use Domain\Mail\Messageable;

class SendGridTransport extends Transport
{

    public function __construct()
    {

    }

    public function send(Messageable $message)
    {
        // TODO: Implement send() method.
    }
}