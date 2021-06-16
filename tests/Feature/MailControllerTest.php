<?php


namespace Tests\Feature;


use Domain\Application\Model\LogEmail;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class MailControllerTest extends \TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    /** @test  */
    public function it_should_show_all_mails()
    {
        $logs = LogEmail::factory()->count(3)->create();
        $response = $this->get('/api/mail');
        $response->seeJsonStructure([
            ['id', 'name', 'created_at', 'status', 'transport', 'email', 'body']
        ]);
        $response->assertResponseOk();
    }
    

}