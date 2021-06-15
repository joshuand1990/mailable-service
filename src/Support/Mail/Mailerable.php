<?php


namespace Domain\Support\Mail;


interface Mailerable
{
    public function send(Message $message);
    public function getTransports(): array;
    public function setCurrentTransport(string $transport);
    public function getCurrentTransport(): string;
}