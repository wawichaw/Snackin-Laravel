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
                'nom_biscuit' => 'Cookie Original',
                'prix' => 2.00,
                'description' => 'Notre biscuit signature',
                'saveur_id' => $saveurs->where('nom_saveur', 'Original')->first()->id
            ],
            [
                'nom_biscuit' => 'Cookie Chocolat',
                'prix' => 2.50,
                'description' => 'Biscuit au chocolat noir intense',
                'saveur_id' => $saveurs->where('nom_saveur', 'Chocolat')->first()->id
            ],
            [
                'nom_biscuit' => 'Cookie Caramel',
                'prix' => 2.50,
                'description' => 'Biscuit au caramel salé',
                'saveur_id' => $saveurs->where('nom_saveur', 'Caramel')->first()->id
            ],
            [
                'nom_biscuit' => 'Cookie Vanille',
                'prix' => 2.25,
                'description' => 'Biscuit à la vanille naturelle',
                'saveur_id' => $saveurs->where('nom_saveur', 'Vanille')->first()->id
            ],
            [
                'nom_biscuit' => 'Cookie Smores',
                'prix' => 3.00,
                'description' => 'Biscuit façon smores avec guimauve et chocolat',
                'saveur_id' => $saveurs->where('nom_saveur', "S'mores")->first()->id
            ],
            [
                'nom_biscuit' => 'Cookie Oreo',
                'prix' => 2.75,
                'description' => 'Biscuit style Oreo',
                'saveur_id' => $saveurs->where('nom_saveur', 'Oreo')->first()->id
            ]
        ];

        foreach ($biscuits as $biscuit) {
            Biscuit::create($biscuit);
        }
    }
}
