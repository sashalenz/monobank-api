<?php

namespace Sashalenz\MonobankApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class AcquiringWebhookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(
            $this->ip(),
            $this->allowedIPs(),
            true
        );
    }

    public function rules(): array
    {
        return [
            'invoiceId' => ['required', 'string'],
            'status' => ['required', 'string'],
            'amount' => ['required', 'integer'],
            'ccy' => ['required', 'integer'],
            'finalAmount' => ['nullable', 'integer'],
            'failureReason' => ['nullable', 'string'],
            'errCode' => ['nullable', 'string'],
            'createdDate' => ['nullable', 'string'],
            'modifiedDate' => ['nullable', 'string'],
            'reference' => ['nullable', 'string'],
            'cancelList' => ['nullable', 'array'],
        ];
    }

    private function allowedIPs(): array
    {
        return Config::get('monobank-api.webhook_ips', []);
    }
}
