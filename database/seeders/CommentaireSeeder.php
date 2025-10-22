<?php

namespace Database\Seeders;

use App\Models\Commentaire;
use Illuminate\Database\Seeder;

class CommentaireSeeder extends Seeder
{
    public function run(): void
    {
        Commentaire::insert([
            ['biscuit_id'=>1,'contenu'=>'tres bon','auteur_affiche'=>'goufi','created_at'=>now(), 'updated_at'=>now()],
            ['biscuit_id'=>1,'contenu'=>'tres bon','auteur_affiche'=>'Anonyme','created_at'=>now(), 'updated_at'=>now()],
        ]);
    }
}
