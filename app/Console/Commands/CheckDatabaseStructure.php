<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CheckDatabaseStructure extends Command
{
    protected $signature = 'db:check-structure';
    protected $description = 'Check database structure and tables';

    public function handle()
    {
        $this->info('Checking database structure...');
        
        // Check connection
        try {
            DB::connection()->getPdo();
            $this->info('✓ Database connection successful');
        } catch (\Exception $e) {
            $this->error('✗ Database connection failed: ' . $e->getMessage());
            return;
        }

        // List all tables
        $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
        $this->info("\nTables found:");
        foreach ($tables as $table) {
            $this->line("- {$table->name}");
        }

        // Check each table structure
        foreach ($tables as $table) {
            $this->info("\nStructure of {$table->name}:");
            $columns = DB::select("PRAGMA table_info('{$table->name}')");
            foreach ($columns as $column) {
                $this->line("- {$column->name}: {$column->type} (Nullable: " . ($column->notnull ? 'No' : 'Yes') . ")");
            }
        }
    }
} 