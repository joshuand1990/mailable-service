<?php


namespace Domain\Mail;


class Mailer
{

    public function __construct(string $name, Dispatcher $events = null)
    {
        $this->name = $name;
        $this->events = $events;
    }

    public function queue($view, $queue = null)
    {
        return $view->mailer($this->name)->queue($this->queue);
    }
}