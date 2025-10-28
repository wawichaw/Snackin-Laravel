<?php

namespace Database\Factories;

use App\Models\Commande;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commande>
 */
class CommandeFactory extends Factory
{
    protected $model = Commande::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = ['en_attente', 'en_preparation', 'prete', 'livree', 'annulee'];
        $tailles = ['4', '6', '12'];
        
        return [
            'utilisateur_id' => null,
            'client_nom' => fake()->name(),
            'client_email' => fake()->email(),
            'total_prix' => fake()->randomFloat(2, 15, 50),
            'status' => fake()->randomElement($status),
            'details_json' => json_encode([
                'taille' => fake()->randomElement($tailles),
                'quantites' => []
            ]),
        ];
    }
}

