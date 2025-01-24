<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Sashalenz\MonobankApi\Http\Controllers\WebhookController;

Route::prefix('monobank-api')
    ->domain(Config::get('monobank-api.webhook_domain'))
    ->as('monobank-api.')
    ->post(Config::get('monobank-api.webhook_key'), WebhookController::class)
    ->name('webhook');
