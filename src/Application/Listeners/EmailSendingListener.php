<?php


namespace Domain\Application\Listeners;


use Domain\Application\Model\LogEmail;
use Domain\Support\Events\EmailSending;

class EmailSendingListener
{
    public function handle(EmailSending $event)
    {
        $logmail = LogEmail::findOrFail($event->message->getId());
        $logmail->setAsSending();
        $logmail->transport = $event->transport;
        $logmail->save();
    }
}