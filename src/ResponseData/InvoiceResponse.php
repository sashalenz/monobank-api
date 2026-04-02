<?php

namespace Sashalenz\MonobankApi\ResponseData;

use Spatie\LaravelData\Data;

class InvoiceResponse extends Data
{
    public function __construct(
        public string $invoiceId,
        public string $pageUrl,
    ) {}
}
