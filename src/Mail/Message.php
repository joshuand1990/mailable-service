<?php


namespace Domain\Mail;


class Message implements Messageable
{
    protected string $fromName;
    protected string $fromEmail;
    protected array $to = [];
    protected array $cc = [];
    protected array $bcc = [];
    protected string $subject;
    protected string $body;

    public function setFrom(string $name, string $email): self
    {
        $this->fromName = $name;
        $this->fromEmail = $email;
        return $this;
    }

    public function to(string $name, string $email): self
    {
        $this->to[$email] = $name;
        return $this;
    }

    public function cc(string $name, string $email): self
    {
        $this->cc[$email] = $name;
        return $this;
    }

    public function bcc(string $name, string $email): self
    {
        $this->bcc[$email] = $name;
        return $this;
    }

    public function getFromName(): string
    {
        return $this->fromName;
    }

    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    public function getTo(): array
    {
        return $this->to;
    }

    public function getCc(): array
    {
        return $this->cc;
    }

    public function getBcc(): array
    {
        return $this->bcc;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setSubject(string $subject) : self
    {
        $this->subject = $subject;
        return $this;
    }

}