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
                'nom_saveur' => 'Original',
                'description' => 'Le goût classique et authentique',
                'emoji' => '🍪'
            ],
            [
                'nom_saveur' => 'Chocolat',
                'description' => 'Saveur chocolatée intense',
                'emoji' => '🍫'
            ],
            [
                'nom_saveur' => 'Caramel',
                'description' => 'Saveur caramel onctueuse',
                'emoji' => '🍮'
            ],
            [
                'nom_saveur' => 'Vanille',
                'description' => 'Saveur vanille naturelle',
                'emoji' => '🌼'
            ],
            [
                'nom_saveur' => "S'mores",
                'description' => 'Goût de guimauve grillée et chocolat',
                'emoji' => '🔥🍫'
            ],
            [
                'nom_saveur' => 'Oreo',
                'description' => 'Saveur biscuit et crème',
                'emoji' => '🍪'
            ]
        ];

        foreach ($saveurs as $saveur) {
            Saveur::create($saveur);
        }
    }
}
