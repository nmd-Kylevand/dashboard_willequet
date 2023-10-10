<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'color' => fake()->safeHexColor(),
            'name' => fake()->name(),
            'address' => fake()->address(),
            'type' => fake()->mimeType(),
            'averageAmount' => fake()->numberBetween(0,200),
            'email' => fake()->unique()->safeEmail(),
            'telephone' => fake()->e164PhoneNumber(),
            'description' => fake()->text(50)
        ];
    }
}
