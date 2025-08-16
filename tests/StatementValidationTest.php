<?php

use Illuminate\Support\Facades\Http;
use Sashalenz\MonobankApi\Exceptions\MonobankApiException;
use Sashalenz\MonobankApi\MonobankApi;

beforeEach(function () {
    config(['monobank-api.api_url' => 'https://api.test/']);
    Http::fake(['*' => Http::response([])]);
});

it('allows requesting statement without end date', function () {
    MonobankApi::personal()->statement('acc', 1);
})->expectNotToPerformAssertions();

it('throws when start date is after end date', function () {
    expect(fn () => MonobankApi::personal()->statement('acc', 5, 1))
        ->toThrow(MonobankApiException::class);
});

it('throws when date range exceeds 31 days', function () {
    $from = 1;
    $to = $from + 2682001;

    expect(fn () => MonobankApi::personal()->statement('acc', $from, $to))
        ->toThrow(MonobankApiException::class);
});
