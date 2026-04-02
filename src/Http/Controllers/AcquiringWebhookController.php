<?php

namespace Sashalenz\MonobankApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Sashalenz\MonobankApi\Http\Requests\AcquiringWebhookRequest;
use Sashalenz\MonobankApi\ResponseData\AcquiringWebhookData;

class AcquiringWebhookController
{
    public function __invoke(AcquiringWebhookRequest $request): JsonResponse
    {
        $data = AcquiringWebhookData::from($request->validated());

        logger()->info('Monobank acquiring webhook received', [
            'invoiceId' => $data->invoiceId,
            'status' => $data->status->value,
            'amount' => $data->amount,
        ]);

        return response()->json();
    }
}
