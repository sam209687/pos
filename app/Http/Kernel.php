<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        // ... other middlewares
        'role' => \App\Http\Middleware\CheckRole::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            // ... existing middleware
            \App\Http\Middleware\SecurityHeaders::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
        ],
    ];
}
