<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'second_name' => $this->faker->lastName(),
            'personal_phone' => '09' . $this->faker->randomNumber(8),
            'address' => $this->faker->streetAddress,
            'password' => Hash::make('password'), // password
            'email' => $this->faker->unique()->safeEmail(),
            'birthdate' => $this->faker->dateTimeBetween('-50 years', 'now'),

            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }


    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
