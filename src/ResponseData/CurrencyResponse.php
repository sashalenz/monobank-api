<?php

namespace Sashalenz\MonobankApi\ResponseData;

use Illuminate\Support\Carbon;
use Sashalenz\MonobankApi\Enums\Currency;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class CurrencyResponse extends Data
{
    public function __construct(
        public Currency $currencyCodeA,
        public Currency $currencyCodeB,
        #[WithCast(DateTimeInterfaceCast::class, format: 'timestamp')]
        public Carbon $date,
        public float $rateSell,
        public float $rateBuy,
        public float $rateCross,
    ) {}
}
