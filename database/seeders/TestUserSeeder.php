<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Test Admin',
            'email' => 'testadmin@example.com',
            'password' => 'password123',
            'role' => 'admin',
            'status' => true
        ]);
    }
} 