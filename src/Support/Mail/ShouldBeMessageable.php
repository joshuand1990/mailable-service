<?php


namespace Domain\Support\Mail;


interface ShouldBeMessageable
{
    public function toMessage(): Messageable;
}