<?php


namespace Tests\Domain\Support\Mail\Transports;


use Domain\Support\Mail\Transports\MailJetTransport;
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
}