<?php

namespace Sashalenz\MonobankApi\ResponseData;

use Illuminate\Support\Carbon;
use Sashalenz\MonobankApi\Enums\InvoiceStatus;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class AcquiringWebhookData extends Data
{
    public function __construct(
        public string $invoiceId,
        public InvoiceStatus $status,
        public int $amount,
        public int $ccy,
        public ?int $finalAmount = null,
        public ?string $failureReason = null,
        public ?string $errCode = null,
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon $createdDate = null,
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon $modifiedDate = null,
        public ?string $reference = null,
        public ?array $cancelList = null,
    ) {}
}
