<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SecurityServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Enable SQL query logging in development
        if (config('app.debug')) {
            DB::listen(function ($query) {
                \Log::info(
                    $query->sql,
                    $query->bindings,
                    $query->time
                );
            });
        }

        // Custom validation rules
        Validator::extend('no_script', function ($attribute, $value) {
            return !preg_match('/<script\b[^>]*>(.*?)<\/script>/is', $value);
        });

        Validator::extend('safe_string', function ($attribute, $value) {
            return !preg_match('/[<>\'"]/', $value);
        });
    }
}
