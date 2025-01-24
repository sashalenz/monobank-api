<?php

namespace Sashalenz\MonobankApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebhookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return array_key_exists(
            $this->ip(),
            $this->allowedIPs()
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
        return [];
    }
}
