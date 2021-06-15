<?php

namespace App\Jobs;

use Domain\Support\Mail\Mailerable;
use Domain\Support\Mail\Messageable;

class SendTransactionalEmailJob extends Job
{
    protected Messageable $message;
    /**
     * @var string
     */
    protected string $transport ;
    public int $tries = 6;
    public int $maxExceptions = 5;
    public array $backoff = [ 2, 5, 10, 30 ];
    public array $usedTransports = [];
    private Mailerable $mailer;

    public function __construct(Messageable $message)
    {
        $this->message = $message;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var Mailerable $mailer */
        $this->mailer = app()->make('mailer');
        $this->mailer->send($this->message);
    }
}
