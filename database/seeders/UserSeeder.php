<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'role' => 'Admin',
            'email' => 'admin@email.com',
            'mobile_number' => '09123456789',
            'password' => bcrypt('password')
        ]);
    }
}
