<?php


namespace Domain\Support\Mail;


use Exception;

class AutoSwappingMailer implements Mailerable
{
    protected Mailerable $mailer;
    protected static array $usedTransports = [];
    /**
     * AutoSwappingMailer constructor.
     */
    public function __construct(Mailerable $mailer)
    {
        $this->mailer = $mailer;
        $this->swapTransportIfException();
    }

      public function swapTransportIfException()
    {
        $transports = array_diff(array_unique(static::$usedTransports), $this->mailer->getTransports());
        if(count($transports) == 0) {
            $transports = $this->mailer->getTransports();
            static::$usedTransports = [];
        }
        foreach($transports as $transport) {
            $this->mailer->setCurrentTransport($transport);
            return;
        }
    }

    public function send(Message $message)
    {
        try {
            $this->mailer->send($message);
        }catch (Exception $e) {
            static::$usedTransports[$this->getCurrentTransport()] = $this->getCurrentTransport();
        }
    }

    public function getTransports(): array
    {
        $this->mailer->getTransports();
    }

    public function setCurrentTransport(string $transport): self
    {
        $this->mailer->setCurrentTransport($transport);
        return $this;
    }

    public function getCurrentTransport(): string
    {
        return $this->mailer->getCurrentTransport();
    }
}