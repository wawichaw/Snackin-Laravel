<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@snackin.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
        
        User::create([
            'name' => 'Utilisateur Test',
            'email' => 'user@snackin.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
    }
}
