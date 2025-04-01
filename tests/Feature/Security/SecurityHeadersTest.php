<?php

namespace Tests\Feature\Security;

use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    public function test_security_headers_are_present()
    {
        $response = $this->get('/');

        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    public function test_csrf_protection()
    {
        $response = $this->post('/login');
        $response->assertStatus(419);
    }

    public function test_rate_limiting()
    {
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post('/login');
        }
        
        $response->assertStatus(429);
    }
}
