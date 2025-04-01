<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic products',
                'status' => true
            ],
            [
                'name' => 'Clothing',
                'description' => 'Clothing items',
                'status' => true
            ],
            [
                'name' => 'Food',
                'description' => 'Food items',
                'status' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 