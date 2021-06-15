<?php


namespace Domain\Support\Mail;


use Exception;

class AutoSwappingMailer implements Mailerable
{
    protected Mailerable $mailer;
    protected array $usedTransports = [];
    /**
     * AutoSwappingMailer constructor.
     */
    public function __construct(Mailerable $mailer)
    {
        $this->mailer = $mailer;
    }

    public function swapTransportIfException(): self
    {
        $transports = array_diff($this->mailer->getTransports(), $this->usedTransports);
        if(count($transports) == 0) {
            $transports = $this->mailer->getTransports();
            $this->usedTransports = [];
        }
        foreach($transports as $transport) {
            $this->mailer->setCurrentTransport($transport);
            return $this;
        }
        return $this;
    }

    public function send(Message $message)
    {
        try {
            $this->mailer->send($message);
        }catch (Exception $e) {
            $this->usedTransports[$this->getCurrentTransport()] = $this->getCurrentTransport();
            $this->swapTransportIfException();
        }
    }
    public function getUsedTransports(): array
    {
        return $this->usedTransports;
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