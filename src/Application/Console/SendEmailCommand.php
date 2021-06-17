<?php


namespace Domain\Application\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendEmailCommand extends Command
{
    protected $signature = 'mail:send {to} {subject} {body}';

    public function handle()
    {
        $tos = [];
        foreach(explode(",", $this->argument('to')) as $to) {
            $to = explode(":", $to);
            $tos[$to[0]] = $to[1] ?? $to[0];
        }
        $subject = $this->argument('subject');
        $body = $this->argument('body');

        foreach ($tos as $to) {
            $name = $to;
            Http::post("\api\mail", compact('to', 'subject', 'body', 'name'));
        }
    }
}