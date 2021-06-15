<?php

namespace App\Jobs;

use Domain\Mail\Mailer;
use Domain\Mail\Messageable;

class SendMailJob extends Job
{
    protected Messageable $message;
    /**
     * @var string
     */
    protected string $transport ;
    public int $tries = 6;
    public int $maxExceptions = 5;
    public array $backoff = [ 2, 5, 10, 30 ];
    public array $drivers = [];

    public function __construct(Messageable $message, string $transport = '')
    {
        $this->message = $message;
        $this->transport = $transport;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var Mailer $mailer */
        $mailer = app()->make('mailer');
        throw new \Exception();
        $mailer->send($this->message);
    }
    public function failed()
    {
        $this->drivers[$this->transport] = $this->transport;
        var_dump("Failed");
    }
}
