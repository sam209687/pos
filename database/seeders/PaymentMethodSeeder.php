<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $paymentMethods = [
            [
                'name' => 'Cash',
                'description' => 'Cash payment',
                'status' => true
            ],
            [
                'name' => 'UPI',
                'description' => 'UPI payment',
                'status' => true
            ],
            [
                'name' => 'Card',
                'description' => 'Card payment',
                'status' => true
            ]
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create($method);
        }
    }
} 