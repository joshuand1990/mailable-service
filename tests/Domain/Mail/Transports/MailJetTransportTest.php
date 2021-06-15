<?php


namespace Tests\Domain\Mail\Transports;


use Domain\Mail\Message;
use Domain\Mail\Transports\MailJetTransport;
use InvalidArgumentException;
use PHPUnit\TextUI\XmlConfiguration\PHPUnit;


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
    /** @test */
    public function it_should_format_the_message_correctly()
    {
        $expectation = [
            "Messages" => [
                "Form" => [
                    "Email" => $fromEmail = $this->faker->email,
                    "Name" => $fromName = $this->faker->name
                ],
                "To" => [
                    [ "Email" => $toEmail = $this->faker->email, "Name" => $toName = $this->faker->name ]
                ],
                "Subject" => $subject = $this->faker->text(50),
                "TextPart" => $body = $this->faker->text(),
                "HTMLPart" => ''
    ]
        ];
        $message = new Message();
        $message->from($fromName, $fromEmail);
        $message->to($toName, $toEmail);
        $message->subject($subject);
        $message->body($body);

        $transport = new MailJetTransport(null, $this->faker->randomNumber(), $this->faker->randomNumber());
        $this->assertEquals($expectation, $transport->formatMessage($message));


    }


}