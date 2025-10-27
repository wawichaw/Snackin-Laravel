<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EnsureAdminUserSeeder extends Seeder
{
    public function run(): void
    {
    // Utilisateur admin demandé : admin@hotmail.com / mot de passe : admin
    $email = 'admin@hotmail.com';
        $user = User::where('email', $email)->first();
        if (!$user) {
            User::create([
                'name' => 'admin',
                'email' => $email,
                'password' => Hash::make('admin'),
                'role' => 'ADMIN',
                'is_admin' => true,
            ]);
        } else {
            $user->update([
                'name' => 'admin',
                'password' => Hash::make('admin'),
                'role' => 'ADMIN',
                'is_admin' => true,
            ]);
        }
    }
}
