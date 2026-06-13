<?php

return [
    'api_url' => env('MONOBANK_API_URL', 'https://api.monobank.ua/'),

    /*
     | Webhook route registration. Configure where + how the package mounts its
     | webhook routes (Livewire-style): toggle them off entirely, or set the
     | domain / path prefix / middleware guards. All defaults preserve the prior
     | behaviour (enabled, `monobank-api` prefix, any host, no middleware).
     */
    'webhook_routes_enabled' => filter_var(
        env('MONOBANK_WEBHOOK_ROUTES_ENABLED', true),
        FILTER_VALIDATE_BOOLEAN
    ),
    'webhook_domain' => env('MONOBANK_WEBHOOK_DOMAIN'),
    'webhook_prefix' => env('MONOBANK_WEBHOOK_PREFIX', 'monobank-api'),
    'webhook_middleware' => array_filter(
        explode(',', env('MONOBANK_WEBHOOK_MIDDLEWARE', ''))
    ),

    'webhook_key' => env('MONOBANK_WEBHOOK_KEY', 'webhook'),
    'acquiring_webhook_key' => env('MONOBANK_ACQUIRING_WEBHOOK_KEY', 'acquiring-webhook'),
    'webhook_ips' => array_filter(
        explode(',', env('MONOBANK_WEBHOOK_IPS', ''))
    ),
];
