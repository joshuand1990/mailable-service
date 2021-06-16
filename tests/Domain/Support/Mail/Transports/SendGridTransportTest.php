<?php


namespace Tests\Domain\Support\Mail\Transports;

use Domain\Support\Mail\Transports\SendGridTransport;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use InvalidArgumentException;
use Tests\Domain\Support\Mail\SetUpMessageTrait;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class SendGridTransportTest extends \TestCase
{
    use SetUpMessageTrait, SwapTransportsTrait;
    /** @test */
    public function it_should_throw_exception_for_validation()
    {
        $this->expectException(InvalidArgumentException::class);
        $transport = new SendGridTransport(null, []);

    }
      /** @test */
    public function it_should_throw_error_when_response_is_invalid()
    {
        $this->expectException(TransferException::class);
        $mailjetMockHandler = $this->swapSendGridInstance();
        $mailjetMockHandler->append(new RequestException("Error", new Request('POST', SendGridTransport::VERSION.'/mail/send'), new Response(500, [])));
        $message = $this->setUpMessage();
        $mailjet = app(SendGridTransport::class);
        $this->assertTrue($mailjet->submit($message));
    }
}