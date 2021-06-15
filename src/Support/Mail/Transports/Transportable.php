<?php


namespace Domain\Support\Mail\Transports;


use Domain\Support\Mail\Messageable;

interface Transportable
{
    public function submit(Messageable $message);

}