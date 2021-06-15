<?php


namespace Tests\Domain\Support\Mail;


use Domain\Support\Mail\Message;

trait SetUpMessageTrait
{
 public function setUpMessage($fromName = null, $fromEmail = null, $toName = null, $toEmail = null, $subject = null, $body = null): Message
    {
        $message = new Message();
        $message->from($fromName ?? $this->faker->name, $fromEmail ?? $this->faker->email);
        $message->to($toName ?? $this->faker->name, $toEmail ?? $this->faker->email);
        $message->subject($subject ?? $this->faker->text(50));
        $message->body($body ?? $this->faker->text());
        return $message;
    }
}