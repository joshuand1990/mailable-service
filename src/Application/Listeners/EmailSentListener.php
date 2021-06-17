<?php


namespace Domain\Application\Listeners;


use Domain\Application\Model\LogEmail;
use Domain\Support\Events\EmailSent;

class EmailSentListener extends BaseEmailListener
{

   function processStatusUpdate(LogEmail $logmail)
    {
        $logmail->setAsSent();
    }
}