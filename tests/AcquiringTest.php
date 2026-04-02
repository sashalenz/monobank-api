<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Sashalenz\MonobankApi\Enums\PaymentType;
use Sashalenz\MonobankApi\Exceptions\MonobankApiException;
use Sashalenz\MonobankApi\MonobankApi;
use Sashalenz\MonobankApi\RequestData\InvoiceData;
use Sashalenz\MonobankApi\RequestData\MerchantPaymInfo;
use Sashalenz\MonobankApi\ResponseData\InvoiceResponse;

beforeEach(function () {
    config(['monobank-api.api_url' => 'https://api.test/']);
});

it('creates a minimal invoice and returns invoiceId and pageUrl', function () {
    Http::fake([
        '*' => Http::response([
            'invoiceId' => 'p2_9ZgpZVsl3',
            'pageUrl' => 'https://pay.mbnk.biz/p2_9ZgpZVsl3',
        ]),
    ]);

    $response = MonobankApi::acquiring()
        ->token('test-merchant-token')
        ->createInvoice(new InvoiceData(amount: 4200));

    expect($response)->toBeInstanceOf(InvoiceResponse::class)
        ->and($response->invoiceId)->toBe('p2_9ZgpZVsl3')
        ->and($response->pageUrl)->toBe('https://pay.mbnk.biz/p2_9ZgpZVsl3');
});

it('sends X-Token header with merchant token', function () {
    Http::fake(function (Request $request) {
        expect($request->header('X-Token'))->toBe(['test-merchant-token']);

        return Http::response(['invoiceId' => 'abc', 'pageUrl' => 'https://pay.mbnk.biz/abc']);
    });

    MonobankApi::acquiring()
        ->token('test-merchant-token')
        ->createInvoice(new InvoiceData(amount: 1000));
});

it('creates an invoice with full merchant payment info', function () {
    Http::fake([
        '*' => Http::response([
            'invoiceId' => 'p2_full',
            'pageUrl' => 'https://pay.mbnk.biz/p2_full',
        ]),
    ]);

    $response = MonobankApi::acquiring()
        ->token('test-merchant-token')
        ->createInvoice(InvoiceData::from([
            'amount' => 4200,
            'ccy' => 980,
            'merchantPaymInfo' => [
                'reference' => 'order-123',
                'destination' => 'Покупка щастя',
                'comment' => 'Test order',
                'basketOrder' => [
                    ['name' => 'Табуретка', 'qty' => 2, 'sum' => 2100, 'total' => 4200, 'unit' => 'шт.'],
                ],
            ],
            'redirectUrl' => 'https://example.com/result',
            'webHookUrl' => 'https://example.com/webhook',
            'validity' => 3600,
            'paymentType' => 'debit',
        ]));

    expect($response->invoiceId)->toBe('p2_full');
});

it('throws MonobankApiException on API error', function () {
    Http::fake(['*' => Http::response(['errorDescription' => 'Invalid token'], 403)]);

    expect(fn () => MonobankApi::acquiring()
        ->token('bad-token')
        ->createInvoice(new InvoiceData(amount: 100))
    )->toThrow(MonobankApiException::class);
});

it('contains expected payment types', function () {
    expect(PaymentType::DEBIT->value)->toBe('debit')
        ->and(PaymentType::HOLD->value)->toBe('hold');
});
