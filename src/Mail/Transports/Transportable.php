<?php


namespace Domain\Mail\Transports;


use Domain\Mail\Messageable;

interface Transportable
{
    public function send(Messageable $message);

}