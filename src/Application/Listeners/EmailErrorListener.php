<?php


namespace Domain\Application\Listeners;


use Domain\Application\Model\LogEmail;

class EmailErrorListener extends BaseEmailListener
{
    function processStatusUpdate(LogEmail $logmail)
    {
        $logmail->setAsError();
    }
}