<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SaveurSeeder::class,
            BiscuitSeeder::class,
            CommentaireSeeder::class,
            UtilisateurSeeder::class,
            CommandeSeeder::class,
        ]);
    }
}
