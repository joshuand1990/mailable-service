<?php


namespace Domain\Mail\Transports;


use Domain\Mail\Messageable;

interface Transportable
{
    public function submit(Messageable $message);

}