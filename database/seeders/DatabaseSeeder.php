<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@isiburger.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Créer un utilisateur de test
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Créer 8 utilisateurs aléatoires
        User::factory(8)->create([
            'role' => 'user',
            'password' => Hash::make('password'),
        ]);

        // Lancer les autres seeders
        $this->call([
            BurgerSeeder::class,
            // OrderSeeder::class,
        ]);
    }
}
