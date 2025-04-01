<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected function createAdmin()
    {
        return User::factory()->create([
            'role' => 'admin',
            'status' => true
        ]);
    }

    protected function createCashier()
    {
        return User::factory()->create([
            'role' => 'cashier',
            'status' => true
        ]);
    }
}
