<?php


namespace Domain\Application\Listeners;


use Domain\Application\Model\LogEmail;
use Domain\Support\Events\EmailEventable;

abstract class BaseEmailListener
{
    public function handle(EmailEventable $event)
    {
        $this->logEmail($event->getMessage()->getId(), $event->getTransport());
    }
    public function logEmail($id, $transport)
    {
        $logmail = LogEmail::findOrFail($id);
        $this->processStatusUpdate($logmail);
        $logmail->transport = $transport;
        $logmail->save();
    }
    abstract function processStatusUpdate(LogEmail $logmail);
}