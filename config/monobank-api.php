<?php

return [
    'api_url' => env('MONOBANK_API_URL', 'https://api.monobank.ua/'),
    'webhook_domain' => env('MONOBANK_WEBHOOK_DOMAIN'),
    'webhook_key' => env('MONOBANK_WEBHOOK_KEY', 'webhook'),
    'acquiring_webhook_key' => env('MONOBANK_ACQUIRING_WEBHOOK_KEY', 'acquiring-webhook'),
    'webhook_ips' => array_filter(
        explode(',', env('MONOBANK_WEBHOOK_IPS', ''))
    ),
];
