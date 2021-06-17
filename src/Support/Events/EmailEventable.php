<?php


namespace Domain\Support\Events;


use Domain\Support\Mail\Messageable;

interface EmailEventable
{
    public function getMessage(): Messageable;
    public function getTransport(): string;
}