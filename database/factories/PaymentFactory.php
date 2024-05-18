<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'by' => fake()->randomElement(['stripe', 'paypal']),
            'key' => fake()->uuid(),
            'status' => 'completed',
            'payment_source' => fake()->optional()->word(),
        ];
    }
}
