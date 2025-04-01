<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductTest extends TestCase
{
    public function test_product_has_correct_fillable_attributes()
    {
        $product = new Product();
        $fillable = [
            'category_id',
            'brand_id',
            'name',
            'code',
            'description',
            'price',
            'cost_price',
            'quantity',
            'alert_quantity',
            'image',
            'status'
        ];

        $this->assertEquals($fillable, $product->getFillable());
    }

    public function test_product_belongs_to_category()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals($category->id, $product->category->id);
    }

    public function test_is_low_stock_returns_correct_value()
    {
        $product = Product::factory()->create([
            'quantity' => 5,
            'alert_quantity' => 10
        ]);

        $this->assertTrue($product->isLowStock());

        $product->quantity = 15;
        $this->assertFalse($product->isLowStock());
    }
}
