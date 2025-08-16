<?php

use Sashalenz\MonobankApi\Http\Requests\WebhookRequest;

it('authorizes requests from allowed IPs', function () {
    config(['monobank-api.webhook_ips' => ['127.0.0.1']]);

    $request = WebhookRequest::create('/', 'POST', [], [], [], ['REMOTE_ADDR' => '127.0.0.1']);
    $request->setContainer(app());
    $request->setRouteResolver(fn () => null);

    expect($request->authorize())->toBeTrue();
});

it('rejects requests from unlisted IPs', function () {
    config(['monobank-api.webhook_ips' => ['127.0.0.1']]);

    $request = WebhookRequest::create('/', 'POST', [], [], [], ['REMOTE_ADDR' => '10.0.0.1']);
    $request->setContainer(app());
    $request->setRouteResolver(fn () => null);

    expect($request->authorize())->toBeFalse();
});
