<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 5 user manual
        $users = [
            ['name' => 'User One',   'username' => 'user1', 'email' => 'user1@example.com'],
            ['name' => 'User Two',   'username' => 'user2', 'email' => 'user2@example.com'],
            ['name' => 'User Three', 'username' => 'user3', 'email' => 'user3@example.com'],
            ['name' => 'User Four',  'username' => 'user4', 'email' => 'user4@example.com'],
            ['name' => 'User Five',  'username' => 'user5', 'email' => 'user5@example.com'],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['email'],
                'password' => Hash::make('password'), // default password
                'role' => 'Admin',
            ]);
        }
    }
}
