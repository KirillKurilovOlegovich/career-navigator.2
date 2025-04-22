<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'surname' => 'admin',
            'email' => 'admin@gmail.com',
            'number' => '00000000000',
            'is_admin' => true,
            'password' => Hash::make('00000000'),
        ]);
        User::factory()->create([
            'name' => 'user',
            'surname' => 'user',
            'email' => 'user@user.com',
            'number' => '00000000000',
            'is_admin' => false,
            'password' => Hash::make('00000000'),
        ]);
    }
}
