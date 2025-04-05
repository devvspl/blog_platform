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
        // Create 1 Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create 2 Author Users
        User::create([
            'name' => 'Author One',
            'email' => 'author1@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'author',
        ]);

        User::create([
            'name' => 'Author Two',
            'email' => 'author2@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'author',
        ]);
    }
}
