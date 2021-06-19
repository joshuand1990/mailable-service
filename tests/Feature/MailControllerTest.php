<?php


namespace Tests\Feature;


use App\Jobs\SendTransactionalEmailJob;
use Domain\Application\Model\LogEmail;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Queue;
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
            ['id', 'name', 'created_at', 'status', 'transport', 'email']
        ]);
        $response->assertResponseOk();
    }
    /** @test  */
    public function it_should_throw_error_for_invalid_input()
    {
        $this->post('/api/mail')->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }
    /** @test  */
    public function it_should_validate_input()
    {
        $this->withoutExceptionHandling();
        Queue::fake();
        $this->post('/api/mail', [
            'email' => $email = $this->faker->email, 'name' => $name = $this->faker->name,
            'subject' => $subject = $this->faker->text, 'body' => $body = $this->faker->text
        ])->assertResponseOk();
        Queue::assertPushed(SendTransactionalEmailJob::class);
        $this->seeInDatabase('logemail', compact('email', 'name', 'subject', 'body'));
    }

}