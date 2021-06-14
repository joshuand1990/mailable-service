<?php


namespace Domain\Mail\Transports;


use Domain\Mail\Messageable;

class MailJetTransport extends Transport
{

    public function send(Messageable $message)
    {
        dd(__CLASS__);
    }
}