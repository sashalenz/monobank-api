<?php

namespace Sashalenz\MonobankApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Sashalenz\MonobankApi\Http\Requests\WebhookRequest;

class WebhookController
{
    public function __invoke(WebhookRequest $request): JsonResponse
    {
        logger()->info('Monobank webhook received', $request->validated());

        return response()->json();
    }
}
