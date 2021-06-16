<?php


namespace Database\Factories;

use Domain\Application\Model\LogEmail;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogEmailFactory  extends Factory
{
    protected $model = LogEmail::class;

    public function definition()
    {
        return [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'subject' => $this->faker->text,
            'body' => $this->faker->text,
            'transport' => $this->faker->text(10),
            'status' => $this->faker->boolean
        ];
    }
}