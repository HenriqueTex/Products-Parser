<?php

namespace Database\Factories;

use App\Models\ApiToken;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApiTokenFactory extends Factory
{
    protected $model = ApiToken::class;

    public function definition()
    {

        return [
            'token' => (string)$this->faker->unique()->randomNumber(5),
            'email' => $this->faker->email()
        ];
    }
}
