<?php

namespace Database\Factories;

use App\Models\Saveur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Saveur>
 */
class SaveurFactory extends Factory
{
    protected $model = Saveur::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $saveurs = ['Chocolat', 'Vanille', 'Caramel', 'Original', 'Smores', 'Oreo'];
        $emojis = ['🍫', '🌼', '🍮', '🍪', '🔥🍫', '🍪'];
        
        $index = array_rand($saveurs);
        
        return [
            'nom_saveur' => $saveurs[$index],
            'description' => fake()->sentence(),
            'emoji' => $emojis[$index],
        ];
    }
}

