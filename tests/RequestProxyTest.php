<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Request as HttpRequest;
use Sashalenz\MonobankApi\Request as ApiRequest;

it('passes proxy option to HTTP client', function () {
    config(['monobank-api.api_url' => 'https://api.test/']);
    Http::fake(function (HttpRequest $request) {
        expect($request->getOptions())->toHaveKey('proxy');
        expect($request->getOptions()['proxy'])->toBe('http://proxy.test');

        return Http::response([]);
    });

    $request = new ApiRequest(
        method: 'test',
        params: [],
        headers: [],
        isPost: false,
        cache: null,
        proxy: 'http://proxy.test',
    );

    $request->make();
});
