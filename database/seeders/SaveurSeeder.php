<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Saveur;

class SaveurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $saveurs = [
            [
                'nom_saveur' => 'Chocolat',
                'description' => 'Saveur chocolatée intense'
            ],
            [
                'nom_saveur' => 'Vanille',
                'description' => 'Saveur vanille naturelle'
            ],
            [
                'nom_saveur' => 'Fruit',
                'description' => 'Saveur fruitée fraîche'
            ],
            [
                'nom_saveur' => 'Citron',
                'description' => 'Saveur citronnée acidulée'
            ],
            [
                'nom_saveur' => 'Caramel',
                'description' => 'Saveur caramel onctueuse'
            ],
            [
                'nom_saveur' => 'Noix de Coco',
                'description' => 'Saveur noix de coco exotique'
            ]
        ];

        foreach ($saveurs as $saveur) {
            Saveur::create($saveur);
        }
    }
}
