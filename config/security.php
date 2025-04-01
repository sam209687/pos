<?php

return [
    'password_expiry_days' => 90,
    'max_login_attempts' => 5,
    'lockout_minutes' => 30,
    'session_lifetime' => 120,
    'require_2fa' => env('REQUIRE_2FA', false),
    'allowed_file_types' => ['jpg', 'jpeg', 'png', 'pdf'],
    'max_upload_size' => 5120, // 5MB
];
