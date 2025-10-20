<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Biscuit;
use App\Models\Saveur;

class BiscuitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les saveurs
        $saveurs = Saveur::all();
        
        $biscuits = [
            [
                'nom_biscuit' => 'Chocolat Noir',
                'prix' => 2.50,
                'description' => 'Biscuit au chocolat noir intense',
                'saveur_id' => $saveurs->where('nom_saveur', 'Chocolat')->first()->id
            ],
            [
                'nom_biscuit' => 'Vanille',
                'prix' => 2.00,
                'description' => 'Biscuit à la vanille naturelle',
                'saveur_id' => $saveurs->where('nom_saveur', 'Vanille')->first()->id
            ],
            [
                'nom_biscuit' => 'Framboise',
                'prix' => 2.75,
                'description' => 'Biscuit aux framboises fraîches',
                'saveur_id' => $saveurs->where('nom_saveur', 'Fruit')->first()->id
            ],
            [
                'nom_biscuit' => 'Citron',
                'prix' => 2.25,
                'description' => 'Biscuit au citron zesty',
                'saveur_id' => $saveurs->where('nom_saveur', 'Citron')->first()->id
            ],
            [
                'nom_biscuit' => 'Caramel',
                'prix' => 2.50,
                'description' => 'Biscuit au caramel salé',
                'saveur_id' => $saveurs->where('nom_saveur', 'Caramel')->first()->id
            ],
            [
                'nom_biscuit' => 'Noix de Coco',
                'prix' => 2.00,
                'description' => 'Biscuit à la noix de coco râpée',
                'saveur_id' => $saveurs->where('nom_saveur', 'Noix de Coco')->first()->id
            ]
        ];

        foreach ($biscuits as $biscuit) {
            Biscuit::create($biscuit);
        }
    }
}
