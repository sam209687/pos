<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Product;
use App\Models\PaymentMethod;

class POSControllerTest extends TestCase
{
    private $cashier;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cashier = $this->createCashier();
    }

    public function test_pos_index_requires_authentication()
    {
        $response = $this->get(route('pos.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_cashier_can_access_pos()
    {
        $response = $this->actingAs($this->cashier)
            ->get(route('pos.index'));
        
        $response->assertOk();
        $response->assertViewIs('pos.index');
    }

    public function test_can_process_sale()
    {
        $product = Product::factory()->create(['quantity' => 10]);
        $paymentMethod = PaymentMethod::factory()->create();

        $saleData = [
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                    'unit_price' => $product->price,
                    'subtotal' => $product->price * 2
                ]
            ],
            'payment_method_id' => $paymentMethod->id,
            'total_amount' => $product->price * 2,
            'tax_amount' => 0,
            'discount_amount' => 0,
            'final_amount' => $product->price * 2,
            'paid_amount' => $product->price * 2,
            'change_amount' => 0
        ];

        $response = $this->actingAs($this->cashier)
            ->postJson(route('pos.process-sale'), $saleData);

        $response->assertOk();
        $response->assertJsonStructure(['success', 'sale_id']);
        
        $this->assertDatabaseHas('sales', [
            'user_id' => $this->cashier->id,
            'payment_method_id' => $paymentMethod->id,
            'final_amount' => $product->price * 2
        ]);

        $product->refresh();
        $this->assertEquals(8, $product->quantity);
    }
}
