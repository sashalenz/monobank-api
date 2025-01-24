<?php

namespace Sashalenz\MonobankApi\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Sashalenz\MonobankApi\Http\Requests\WebhookRequest;

class WebhookController
{
    /**
     * @throws Exception
     */
    public function __invoke(WebhookRequest $request): JsonResponse
    {
        info(print_r($request->all(), true));

        return response()->json();
    }
}
