<?php

namespace Sashalenz\MonobankApi\Types;

use Sashalenz\MonobankApi\Enums\AccountType;
use Sashalenz\MonobankApi\Enums\CashbackType;
use Spatie\LaravelData\Data;

class Account extends Data
{
    public function __construct(
        public string $id,
        public string $sendId,
        public int $balance,
        public int $creditLimit,
        public AccountType $type,
        public int $currencyCode,
        public CashbackType $cashbackType,
        public array $maskedPan,
        public string $iban,
    ) {}
}
