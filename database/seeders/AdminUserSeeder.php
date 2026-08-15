<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vérifier si l'utilisateur existe déjà
        $user = User::where('email', 'admin@globallogistics.tg')->first();

        if (!$user) {
            User::create([
                'name' => 'Administrateur',
                'email' => 'nanipobernadine@gmail.com',
                'password' => 'admin123',
            ]);

        } else {
            $this->command->info('ℹ️ L\'administrateur existe déjà.');
            $this->command->info('📧 Email: ' . $user->email);
        }
    }
}