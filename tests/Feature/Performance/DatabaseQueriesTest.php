<?php

namespace Tests\Feature\Performance;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class DatabaseQueriesTest extends TestCase
{
    public function test_pos_page_query_count()
    {
        $this->actingAs($this->createCashier());

        DB::enableQueryLog();
        
        $response = $this->get(route('pos.index'));
        
        $queryCount = count(DB::getQueryLog());
        $this->assertLessThan(10, $queryCount, 'Too many queries being executed');
    }
}
