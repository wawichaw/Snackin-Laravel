<?php

namespace Database\Seeders;

use App\Models\Utilisateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UtilisateurSeeder extends Seeder
{
    public function run(): void
    {
        Utilisateur::insert([
            [
                'prenom'=>'Alice','nom'=>'Demo','identifiant'=>'alice123',
                'mot_de_passe'=> Hash::make('password'),
                'created_at'=>now(),'updated_at'=>now()
            ],
            [
                'prenom'=>'Admin','nom'=>'Admin','identifiant'=>'admin',
                'mot_de_passe'=> Hash::make('admin'),
                'created_at'=>now(),'updated_at'=>now()
            ],
        ]);
    }
}
