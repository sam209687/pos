<?php

namespace Tests\Feature\Integration;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\PaymentMethod;
use App\Models\Sale;

class SalesProcessTest extends TestCase
{
    private $cashier;
    private $product;
    private $paymentMethod;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->cashier = $this->createCashier();
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        
        $this->product = Product::factory()->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'quantity' => 20
        ]);
        
        $this->paymentMethod = PaymentMethod::factory()->create();
    }

    public function test_complete_sales_process()
    {
        // 1. Login as cashier
        $response = $this->post(route('login'), [
            'email' => $this->cashier->email,
            'password' => 'password'
        ]);
        $response->assertRedirect();

        // 2. Access POS page
        $response = $this->get(route('pos.index'));
        $response->assertOk();

        // 3. Process sale
        $saleData = [
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => 2,
                    'unit_price' => $this->product->price,
                    'subtotal' => $this->product->price * 2
                ]
            ],
            'payment_method_id' => $this->paymentMethod->id,
            'total_amount' => $this->product->price * 2,
            'tax_amount' => 0,
            'discount_amount' => 0,
            'final_amount' => $this->product->price * 2,
            'paid_amount' => $this->product->price * 2,
            'change_amount' => 0
        ];

        $response = $this->postJson(route('pos.process-sale'), $saleData);
        $response->assertOk();
        
        // 4. Verify sale record
        $sale = Sale::latest()->first();
        $this->assertNotNull($sale);
        $this->assertEquals($this->cashier->id, $sale->user_id);
        
        // 5. Verify product quantity updated
        $this->product->refresh();
        $this->assertEquals(18, $this->product->quantity);
        
        // 6. Generate receipt
        $response = $this->get(route('payments.receipt', $sale));
        $response->assertOk();
    }
}
