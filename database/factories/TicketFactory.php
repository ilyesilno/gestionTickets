<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sujet' => fake()->text(50),
            'description' => fake()->paragraph(2),
            'user_id' => 2,
            'priorite' => 'haute',
            'categorie' => 'bug',
            
            
        ];
    }
}
