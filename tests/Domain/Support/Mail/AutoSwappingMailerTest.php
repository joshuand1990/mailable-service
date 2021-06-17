<?php


namespace Tests\Domain\Support\Mail;


use Domain\Support\Events\EmailSending;
use Domain\Support\Events\EmailSendingError;
use Domain\Support\Events\EmailSent;
use Domain\Support\Mail\AutoSwappingMailer;
use Domain\Support\Mail\Mailer;
use Domain\Support\Mail\Mailerable;
use Domain\Support\Mail\Transports\MailJetTransport;
use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Tests\Domain\Support\Mail\Transports\SwapTransportsTrait;

class AutoSwappingMailerTest extends \TestCase
{
    use SetUpMessageTrait, SwapTransportsTrait;
    /** @test */
    public function it_should_swap_if_there_is_an_error()
    {
        Event::fake();
        $this->setUpAutoSwappingMailer();
        $this->setDefaultConfigs();
        $this->mockHandlerForMailJetSetToError();
        /** @var Mailerable $mailer */
        $mailer = $this->app->make('mailer');
        $lastTransport = $mailer->getCurrentTransport();
        $this->simulatingErrorHandling($mailer);
        Event::assertDispatched(EmailSendingError::class);
        $this->mockHandlerForSendGridSetToOK();
        Event::assertDispatched(EmailSending::class);
        $mailer->send($this->setUpMessage());
        Event::assertDispatched(EmailSent::class);
        $this->assertTrue($mailer->getCurrentTransport() <> $lastTransport);
    }

    protected function setUpAutoSwappingMailer(): void
    {
        $this->app->singleton('mailer', function ($app) {
            return (new AutoSwappingMailer(new Mailer($app, $app['events'])));
        });
    }

    protected function setDefaultConfigs(): void
    {
        Config::set('mail.default', 'mailjet');
    }

    protected function mockHandlerForMailJetSetToError(): void
    {
        $mailjetMockHandler = $this->swapMailJetInstance();
        $mailjetMockHandler->append(new RequestException("There was an Error", new Request('POST', MailJetTransport::VERSION . '/send'), new Response(500, [])));
    }

    protected function mockHandlerForSendGridSetToOK(): void
    {
        $sendgridMockHandler = $this->swapSendGridInstance();
        $sendgridMockHandler->append(new Response(200, [], ''));
    }

    /**
     * @param Mailerable $mailer
     */
    protected function simulatingErrorHandling(Mailerable $mailer): void
    {
        try {
            $mailer->send($this->setUpMessage());
            Event::assertDispatched('email.sending');
        } catch (Exception $e) {

        }
    }

}