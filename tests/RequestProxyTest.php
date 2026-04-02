<?php

use Illuminate\Support\Facades\Http;
use Sashalenz\MonobankApi\Request as ApiRequest;

it('passes proxy option to HTTP client', function () {
    config(['monobank-api.api_url' => 'https://api.test/']);
    Http::fake(['*' => Http::response([])]);

    $request = new ApiRequest(
        method: 'test',
        params: [],
        headers: [],
        isPost: false,
        cache: null,
        proxy: 'http://proxy.test',
    );

    $request->make();

    Http::assertSent(fn ($req) => $req->url() === 'https://api.test/test');
});
