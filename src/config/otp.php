<?php

return [
    /*
    |--------------------------------------------------------------------------
    | OTP Length
    |--------------------------------------------------------------------------
    |
    | Number of digits used for SMS verification codes. Defaults to 4 digits.
    |
    */
    'length' => (int) env('OTP_LENGTH', 4),

    /*
    |--------------------------------------------------------------------------
    | OTP Lifetime
    |--------------------------------------------------------------------------
    |
    | Number of minutes an OTP should remain valid in cache before expiring.
    |
    */
    'ttl' => (int) env('OTP_TTL', 3),

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | Prefix used when storing OTP codes in the cache driver.
    |
    */
    'cache_prefix' => env('OTP_CACHE_PREFIX', 'auth_otp_'),
];
