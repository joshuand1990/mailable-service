<?php


namespace Tests\Domain\Support\Mail\Transports;

use Domain\Support\Mail\Transports\SendGridTransport;
use InvalidArgumentException;
use Tests\Domain\Support\Mail\SetUpMessageTrait;

class SendGridTransportTest extends \TestCase
{
    use SetUpMessageTrait, SwapTransportsTrait;
    /** @test */
    public function it_should_throw_exception_for_validation()
    {
        $this->expectException(InvalidArgumentException::class);
        $transport = new SendGridTransport(null, []);

    }
}