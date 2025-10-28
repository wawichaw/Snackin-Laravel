<?php

namespace Database\Factories;

use App\Models\Biscuit;
use App\Models\Saveur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Biscuit>
 */
class BiscuitFactory extends Factory
{
    protected $model = Biscuit::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom_biscuit' => fake()->words(2, true) . ' Biscuit',
            'prix' => fake()->randomFloat(2, 5, 40),
            'description' => fake()->sentence(),
            'image' => null,
            'saveur_id' => Saveur::factory(),
        ];
    }
}

