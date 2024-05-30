<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'address' => fake()->streetAddress(),
            'post_code' => fake()->postcode(),
            'city' => fake()->city(),
            'phone_number' => preg_replace('/[^0-9]/', '', fake()->phoneNumber()),
            'is_main' => false,
        ];
    }
}
