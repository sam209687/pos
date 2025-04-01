<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'iPhone 13',
                'code' => 'IP13',
                'description' => 'Latest iPhone model',
                'cost_price' => 799.99,
                'price' => 999.99,
                'quantity' => 10,
                'category_id' => 1, // Electronics
                'brand_id' => 1, // Apple
                'status' => true
            ],
            [
                'name' => 'Samsung Galaxy S21',
                'code' => 'SGS21',
                'description' => 'Samsung flagship phone',
                'cost_price' => 699.99,
                'price' => 899.99,
                'quantity' => 15,
                'category_id' => 1, // Electronics
                'brand_id' => 2, // Samsung
                'status' => true
            ],
            [
                'name' => 'Nike Air Max',
                'code' => 'NAMAX',
                'description' => 'Comfortable running shoes',
                'cost_price' => 89.99,
                'price' => 129.99,
                'quantity' => 20,
                'category_id' => 2, // Clothing
                'brand_id' => 3, // Nike
                'status' => true
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
} 