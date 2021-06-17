<?php


namespace Domain\Application\Listeners;


use Domain\Application\Model\LogEmail;
use Domain\Support\Events\EmailSending;

class EmailSendingListener extends BaseEmailListener
{
    function processStatusUpdate(LogEmail $logmail)
    {
        $logmail->setAsSending();
    }
}