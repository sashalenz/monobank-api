<?php

namespace Sashalenz\MonobankApi\RequestData;

use Spatie\LaravelData\Data;

class WebhookData extends Data
{
    public function __construct(
        public string $webHookUrl,
    ) {}
}
