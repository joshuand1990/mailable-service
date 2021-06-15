<?php


namespace Domain\Support\Mail;


interface Messageable
{
    public function getId(): int;
    public function getFromName(): string;
    public function getFromEmail(): string;
    public function getTo(): array;
    public function getCc(): array;
    public function getBcc(): array;
    public function getSubject(): string;
    public function getBody(): string;

}