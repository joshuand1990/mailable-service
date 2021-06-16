<?php


namespace Tests\Domain\Support\Mail\Transports;


use Domain\Support\Mail\Transports\MailJetTransport;
use Domain\Support\Mail\Transports\SendGridTransport;
use GuzzleHttp\Handler\MockHandler;

trait SwapTransportsTrait
{

    protected function swapMailJetInstance(): MockHandler
    {
        $mockHandler = new MockHandler();
        $client = new MailJetTransport(null, 'xx', 'xx', [
            'handler' => $mockHandler
        ]);

        $this->app->instance(MailJetTransport::class, $client);
        return $mockHandler;
    }
     protected function swapSendGridInstance(): MockHandler
    {
        $mockHandler = new MockHandler();
        $client = new SendGridTransport('xx', [
            'handler' => $mockHandler
        ]);

        $this->app->instance(SendGridTransport::class, $client);
        return $mockHandler;
    }
}