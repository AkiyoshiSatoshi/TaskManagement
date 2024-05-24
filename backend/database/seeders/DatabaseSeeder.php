<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'password' => 'Admin_12345',
            'role' => 1,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@mail.com',
            'password' => 'Test_12345',
            'role' => 10,
        ]);
    }
}
