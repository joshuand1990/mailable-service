<?php
namespace Tests\Domain\Mail;

use Domain\Mail\Mailer;

class MailerTest extends \TestCase
{
    /** @test */
    public function it_should_show_the_configured_default_driver()
    {
        $default = 'xxxy';
        $this->app['config']['mail.default'] = $default;
        $mailer = new Mailer(app());
        $this->assertEquals($default, $mailer->getDefaultDriver());;
    }

    /** @test */
    public function it_should_show_the_drivers_available()
    {
        $this->app['config']['mail.drivers'] = [
            'xxx' => [ 'priority' => 2, 'active' => true ],
            'yyy' => [ 'priority' => 1, 'active' => true ]
        ];
        $mailer = new Mailer(app());
        $this->assertEquals(['yyy', 'xxx'], $mailer->getDrivers()->toArray());
    }

     /** @test */
    public function it_should_show_the_drivers_active()
    {
        $this->app['config']['mail.drivers'] = [
            'xxx' => [ 'priority' => 2, 'active' => true ],
            'yyy' => [ 'priority' => 1, 'active' => false ]
        ];
        $mailer = new Mailer(app());
        $this->assertEquals(['xxx'], $mailer->getDrivers()->toArray());
    }
}