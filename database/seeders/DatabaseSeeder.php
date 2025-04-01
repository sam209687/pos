<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Test@123',
            'role' => 'admin',
            'status' => true
        ]);

        $this->call([
            PaymentMethodSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
