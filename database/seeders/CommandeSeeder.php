<?php

namespace Database\Seeders;

use App\Models\Commande;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CommandeSeeder extends Seeder
{
    public function run(): void
    {
        Commande::insert([
            [
                'utilisateur_id'=>1,'biscuit_id'=>1,'quantite'=>2,
                'date_commande'=>Carbon::today(),
                'created_at'=>now(),'updated_at'=>now()
            ],
        ]);
    }
}
