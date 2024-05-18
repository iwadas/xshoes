<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tracking>
 */
class TrackingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if(rand(1,3) == 3){
            return [
                'status' => 'shipped',
                'url' => fake()->url(),
            ];
        } else {
            return [
                'status' => fake()->randomElement(['received', 'completed'])
            ];
        }
    }
}
