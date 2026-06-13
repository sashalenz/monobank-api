<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Sashalenz\MonobankApi\Http\Controllers\AcquiringWebhookController;
use Sashalenz\MonobankApi\Http\Controllers\WebhookController;

// Webhook routes are fully configurable (domain / prefix / middleware) and can
// be switched off — see config/monobank-api.php. Defaults preserve the prior
// behaviour. Skip registration entirely when disabled.
if (! Config::get('monobank-api.webhook_routes_enabled', true)) {
    return;
}

Route::prefix(Config::get('monobank-api.webhook_prefix', 'monobank-api'))
    ->domain(Config::get('monobank-api.webhook_domain'))
    ->middleware(Config::get('monobank-api.webhook_middleware', []))
    ->as('monobank-api.')
    ->group(function () {
        Route::post(Config::get('monobank-api.webhook_key'), WebhookController::class)
            ->name('webhook');

        Route::post(Config::get('monobank-api.acquiring_webhook_key'), AcquiringWebhookController::class)
            ->name('acquiring-webhook');
    });
