<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Token
    |--------------------------------------------------------------------------
    |
    | Personal access token issued by Kavenegar. A sensible empty fallback is
    | provided so local environments without credentials will not fail hard.
    |
    */
    'token' => env('KAVENEGAR_TOKEN', env('KAVEHNEGAR_TOKEN', '')),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | API base URL. Defaults to the official Kavenegar endpoint.
    |
    */
    'base_url' => rtrim(env('KAVENEGAR_BASE_URL', 'https://api.kavenegar.com/v1/'), '/').'/',

    /*
    |--------------------------------------------------------------------------
    | Default Template
    |--------------------------------------------------------------------------
    |
    | Lookup template name used to send OTP messages.
    |
    */
    'template' => env('KAVENEGAR_TEMPLATE', 'auth'),

    /*
    |--------------------------------------------------------------------------
    | Lookup Endpoint
    |--------------------------------------------------------------------------
    |
    | Endpoint path used for verification lookups.
    |
    */
    'lookup_endpoint' => env('KAVENEGAR_LOOKUP_ENDPOINT', 'verify/lookup.json'),
];
