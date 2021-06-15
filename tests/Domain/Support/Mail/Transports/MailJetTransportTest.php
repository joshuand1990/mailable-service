<?php


namespace Tests\Domain\Support\Mail\Transports;



use Domain\Support\Mail\Transports\MailJetTransport;
use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Tests\Domain\Support\Mail\SetUpMessageTrait;


class MailJetTransportTest extends \TestCase
{
    use SetUpMessageTrait, SwapTransportsTrait;
    /** @test */
    public function it_should_validate_configuration_items()
    {
        $this->expectException(InvalidArgumentException::class);
        $transport = new MailJetTransport();
        $this->assertEquals('https://api.mailjet.com/', $transport->getBaseUrl());
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
        list($expectation, $message) = $this->expectationSetUp();
        $transport = new MailJetTransport(null, $this->faker->randomNumber(), $this->faker->randomNumber());
        $this->assertEquals($expectation, $transport->formatMessage($message));
    }
    /** @test */
    public function it_should_submit_with_ok_status()
    {
        $mockHandler = $this->swapMailJetInstance();
        $mockHandler->append(new Response(200, [], ' {"Messages":[{"Status":"success","CustomID":"AppGettingStartedTest","To":[{"Email":"joshuand1990@gmail.com","MessageUUID":"4fe86ee6-f896-4e5c-a114-9ea05c99c5d8","MessageID":576460760258009797,"MessageHref":"https://api.mailjet.com/v3/REST/message/576460760258009797"}],"Cc":[],"Bcc":[]}]}'));
        list($expectation, $message) = $this->expectationSetUp();
        $mailjet = app(MailJetTransport::class);
        $this->assertTrue($mailjet->submit($message));

    }
    /** @test */
    public function it_should_throw_error_when_response_is_invalid()
    {
        $this->expectException(Exception::class);
        $mailjetMockHandler = $this->swapMailJetInstance();
        $mailjetMockHandler->append(new RequestException("Error", new Request('POST', MailJetTransport::VERSION.'/send'), new Response(500, [])));
        list($expectation, $message) = $this->expectationSetUp();
        $mailjet = app(MailJetTransport::class);
        $this->assertTrue($mailjet->submit($message));
    }

    /**
     * @return array
     */
    protected function expectationSetUp(): array
    {
        $expectation = [
            "Messages" => [
                [
                    "From" => [ "Email" => $fromEmail = $this->faker->email, "Name" => $fromName = $this->faker->name ],
                    "To" => [
                        [ "Email" => $toEmail = $this->faker->email, "Name" => $toName = $this->faker->name ]
                    ],
                    "Subject" => $subject = $this->faker->text(50),
                    "TextPart" => $body = $this->faker->text()
                ]
            ]
        ];
        $message = $this->setUpMessage($fromName, $fromEmail, $toName, $toEmail, $subject, $body);

        return array($expectation, $message);
    }
}