<?php


namespace Tests\Domain\Support\Mail;


class AutoSwappingMailerTest extends \TestCase
{
    /** @test */
    public function it_should_swap_if_there_is_an_error()
    {
        $mailer = app()->make('mailer');

    }
}