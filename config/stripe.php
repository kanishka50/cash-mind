<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Stripe Keys
    |--------------------------------------------------------------------------
    |
    | The Stripe publishable key and secret key give you access to Stripe's
    | API. The "publishable" key is typically used when interacting with
    | Stripe.js while the "secret" key accesses private API endpoints.
    |
    */

    'key' => env('STRIPE_KEY', ''),
    'secret_key' => env('STRIPE_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Stripe Webhooks
    |--------------------------------------------------------------------------
    |
    | Your Stripe webhook secret is used to prevent unauthorized requests to
    | your Stripe webhook handling controllers. The tolerance value defines
    | the number of seconds a timestamp can differ before it's rejected.
    |
    */

    'webhook' => [
        'secret' => env('STRIPE_WEBHOOK_SECRET', ''),
        'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
    ],
];