<?php


namespace Domain\Application\Actions;


use App\Jobs\SendTransactionalEmailJob;
use Domain\Application\Model\LogEmail;
use Illuminate\Support\Facades\Queue;

class StoreEmailAction
{
    private string $name;
    private string $email;
    private string $subject;
    private string $body;


    /**
     * StoreEmailAction constructor.
     */
    public function __construct(string $name, string $email, string $subject, string $body)
    {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->body = $body;
    }

    public function handle()
    {
        $mail = LogEmail::create([
            'name' => $this->name, 'email' => $this->email, 'subject' =>  $this->subject, 'body' => $this->body
            ,'transport' => 'tbd'
        ]);
        Queue::push(new SendTransactionalEmailJob($mail->toMessage()));

    }
}