<?php

namespace Sashalenz\MonobankApi\ResponseData;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class StatementResponse extends Data
{
    public function __construct(
        public string $id,
        #[WithCast(DateTimeInterfaceCast::class, format: 'L')]
        public Carbon $time,
        public string $description,
        public int $mcc,
        public int $originalMcc,
        public bool $hold,
        public int $amount,
        public int $operationAmount,
        public int $currencyCode,
        public int $commissionRate,
        public int $cashbackAmount,
        public int $balance,
        public ?string $comment,
        public ?string $receiptId,
        public ?string $invoiceId,
        public ?string $counterEdrpou,
        public ?string $counterIban,
        public ?string $counterName,
    ) {}
}
