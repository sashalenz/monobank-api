<?php

namespace Sashalenz\MonobankApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class WebhookRequest extends FormRequest
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
            'type' => ['required', 'string'],
            'data' => ['required', 'array'],
            'data.account' => ['required', 'string'],
            'data.statementItem' => ['required'],
        ];
    }

    private function allowedIPs(): array
    {
        return Config::get('monobank-api.webhook_ips', []);
    }
}
