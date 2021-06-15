<?php


namespace Tests\Domain\Mail\Transports;


use Domain\Mail\Transports\MailJetTransport;
use InvalidArgumentException;


class MailJetTransportTest extends \TestCase
{
    /** @test */
    public function it_should_validate_configuration_items()
    {
        $this->expectException(InvalidArgumentException::class);
        $transport = new MailJetTransport();
        $this->assertEquals('https://api.mailjet.com/v3.1', $transport->getBaseUrl());
    }

     /** @test */
    public function it_should_overwrite_url()
    {
        $this->expectException(InvalidArgumentException::class);
        $transport = new MailJetTransport($url = "https://xxxxx");
        $this->assertEquals($url, $transport->getBaseUrl());
    }

}