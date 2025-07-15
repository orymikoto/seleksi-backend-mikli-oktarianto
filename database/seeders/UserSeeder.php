<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Mikli Tester',
            'email' => 'mikli@clavata.com',
            'password' => Hash::make('mikli123'), // Set a secure password
        ]);

        // Create regular test users
        User::factory(10)->create(); // Creates 10 random users
    }
}
