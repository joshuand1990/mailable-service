<?php


namespace Domain\Application\Console;

use Domain\Application\Actions\StoreEmailAction;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendEmailCommand extends Command
{
    protected $signature = 'mail:send '
    . '{to : email recipient, for multiple separate by "," - supports adding names as well eg (john@doe.com:john,jane@doe.com:jane)} '
    . '{subject : email subject} '
    . '{content :  email content} ';

    protected $description = 'Send email from console';

    public function handle()
    {
        try {
            $tos = [];
            foreach (explode(",", $this->argument('to')) as $to) {
                $to = explode(":", $to);
                $tos[$to[0]] = $to[1] ?? $to[0];
            }
            $subject = $this->argument('subject');
            $body = $this->argument('content');

            foreach ($tos as $email => $name) {
                (new StoreEmailAction($name, $email, $subject, $body))->handle();
                $this->info("Queuing: " . $email);
            }
        }catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}