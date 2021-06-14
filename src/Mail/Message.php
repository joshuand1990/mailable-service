<?php


namespace Domain\Mail;


class Message
{
    protected $fromName;
    protected $fromEmail;
    protected $to = [];
    protected $cc = [];
    protected $bcc = [];
    protected $subject;
    protected $body;

    public function setFrom($name, $email)
    {
        return $this;
    }

}