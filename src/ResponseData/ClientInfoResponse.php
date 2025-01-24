<?php

namespace Sashalenz\MonobankApi\ResponseData;

use Illuminate\Support\Carbon;
use Sashalenz\MonobankApi\Enums\Currency;
use Sashalenz\MonobankApi\Types\Account;
use Sashalenz\MonobankApi\Types\Jar;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class ClientInfoResponse extends Data
{
    public function __construct(
        public string $clientId,
        public string $name,
        public string $webHookUrl,
        public string $permissions,
        #[DataCollectionOf(Account::class)]
        public DataCollection $accounts,
        #[DataCollectionOf(Jar::class)]
        public DataCollection $jars,
    ) { }
}
