<?php


namespace Tests\Domain\Support\Mail;


use Domain\Support\Mail\AutoSwappingMailer;
use Domain\Support\Mail\Mailer;
use Domain\Support\Mail\Mailerable;
use Domain\Support\Mail\Transports\MailJetTransport;
use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Config;
use Tests\Domain\Support\Mail\Transports\SwapTransportsTrait;

class AutoSwappingMailerTest extends \TestCase
{
    use SetUpMessageTrait, SwapTransportsTrait;
    /** @test */
    public function it_should_swap_if_there_is_an_error()
    {
        $this->app->singleton('mailer', function ($app) {
            return (new AutoSwappingMailer(new Mailer($app)));
        });
        Config::set('mail.default', 'mailjet');
        $mailjetMockHandler = $this->swapMailJetInstance();
        $mailjetMockHandler->append(new RequestException("There was an Error", new Request('POST', MailJetTransport::VERSION.'/send'), new Response(500, [])));
        /** @var Mailerable $mailer */
        $mailer = $this->app->make('mailer');
        $lastTransport = $mailer->getCurrentTransport();
        try {
            $mailer->send($this->setUpMessage());
        } catch (Exception $e) {

        }

        $sendgridMockHandler = $this->swapSendGridInstance();
        $sendgridMockHandler->append(new Response(200, [], ''));
        $mailer->send($this->setUpMessage());
        $this->assertTrue($mailer->getCurrentTransport() <> $lastTransport);


    }

}