<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CheckDatabaseHealth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check database health and table structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Starting Database Health Check...');
        
        // 1. Check Connection
        $this->info("\n📡 Checking database connection...");
        try {
            $connection = DB::connection()->getPdo();
            $this->info('✅ Database connected successfully');
            $this->info('   Database: ' . DB::connection()->getDatabaseName());
            $this->info('   Version: ' . $connection->getAttribute(\PDO::ATTR_SERVER_VERSION));
        } catch (\Exception $e) {
            $this->error('❌ Database connection failed: ' . $e->getMessage());
            return 1;
        }

        // 2. Check Migrations
        $this->info("\n📋 Checking migration status...");
        $migrations = DB::table('migrations')->get();
        $this->info('✅ Found ' . count($migrations) . ' migrations installed');

        // 3. Check Required Tables
        $this->info("\n📊 Checking required tables...");
        $requiredTables = [
            'users',
            'categories',
            'brands',
            'products',
            'payment_methods',
            'sales',
            'sale_items',
            'migrations',
            'password_resets',
            'failed_jobs',
            'personal_access_tokens'
        ];

        $missingTables = [];
        foreach ($requiredTables as $table) {
            if (!Schema::hasTable($table)) {
                $missingTables[] = $table;
                $this->error("❌ Missing table: {$table}");
            } else {
                $this->info("✅ Table exists: {$table}");
                
                // Show record count for key tables
                if (in_array($table, ['users', 'products', 'categories', 'brands'])) {
                    $count = DB::table($table)->count();
                    $this->line("   Records: {$count}");
                }
            }
        }

        // 4. Check Table Structures
        $this->info("\n🔍 Checking table structures...");
        
        $tableStructures = [
            'users' => [
                'id', 'name', 'email', 'password', 'role', 'status', 'created_at', 'updated_at'
            ],
            'products' => [
                'id', 'category_id', 'brand_id', 'name', 'code', 'description', 
                'price', 'cost_price', 'quantity', 'alert_quantity', 'image', 
                'status', 'created_at', 'updated_at'
            ],
            'sales' => [
                'id', 'user_id', 'payment_method_id', 'total_amount', 'discount_amount',
                'tax_amount', 'final_amount', 'paid_amount', 'change_amount',
                'sale_date', 'sale_time', 'status', 'created_at', 'updated_at'
            ]
        ];

        foreach ($tableStructures as $table => $requiredColumns) {
            if (Schema::hasTable($table)) {
                $this->info("\nChecking {$table} structure:");
                $columns = Schema::getColumnListing($table);
                
                foreach ($requiredColumns as $column) {
                    if (!in_array($column, $columns)) {
                        $this->error("❌ Missing column: {$table}.{$column}");
                    } else {
                        $this->info("✅ Column exists: {$table}.{$column}");
                    }
                }
            }
        }

        // 5. Check Foreign Keys
        $this->info("\n🔗 Checking foreign key relationships...");
        $relationships = [
            'products' => ['category_id' => 'categories', 'brand_id' => 'brands'],
            'sales' => ['user_id' => 'users', 'payment_method_id' => 'payment_methods'],
            'sale_items' => ['sale_id' => 'sales', 'product_id' => 'products']
        ];

        foreach ($relationships as $table => $foreignKeys) {
            if (Schema::hasTable($table)) {
                foreach ($foreignKeys as $column => $referencedTable) {
                    $this->info("Checking {$table}.{$column} -> {$referencedTable}");
                }
            }
        }

        if (!empty($missingTables)) {
            $this->warn("\n⚠️ Action Required: Missing tables detected!");
            $this->line("Run the following command to create missing tables:");
            $this->line("php artisan migrate");
            return 1;
        }

        $this->info("\n✅ Database health check completed successfully!");
        return 0;
    }
}
