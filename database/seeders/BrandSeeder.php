<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Apple',
                'description' => 'Apple products',
                'status' => true
            ],
            [
                'name' => 'Samsung',
                'description' => 'Samsung products',
                'status' => true
            ],
            [
                'name' => 'Nike',
                'description' => 'Nike products',
                'status' => true
            ]
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
} 