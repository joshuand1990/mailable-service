<?php


namespace Tests\Domain\Support\Mail;


use Domain\Support\Mail\AutoSwappingMailer;
use Domain\Support\Mail\Mailer;
use Domain\Support\Mail\Mailerable;
use Domain\Support\Mail\Transports\MailJetTransport;
use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Tests\Domain\Support\Mail\Transports\SwapTransportsTrait;

class AutoSwappingMailerTest extends \TestCase
{
    use SetUpMessageTrait, SwapTransportsTrait;
    /** @test */
    public function it_should_swap_if_there_is_an_error()
    {
        $this->app->singleton('mailer', function ($app) {
            return (new AutoSwappingMailer(new Mailer($app)))->swapTransportIfException();
        });

        $mailjetMockHandler = $this->swapMailJetInstance();
        $mailjetMockHandler->append(new RequestException("Error", new Request('POST', MailJetTransport::VERSION.'/send'), new Response(500, [])));
        /** @var Mailerable $mailer */
        $mailer = $this->app->make('mailer');
        $lastTransport = $mailer->getCurrentTransport();
        $mailer->send($this->setUpMessage());
        $this->assertTrue($mailer->getCurrentTransport() <> $lastTransport);
    }

}