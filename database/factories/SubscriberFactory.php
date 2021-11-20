<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class SubscriberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->name(),
            'last_name'  => $this->faker->name(),
            'email'      => $this->faker->unique()->safeEmail(),
            'birth_day'  => now()->format('Y-m-d'),
        ];
    }
}