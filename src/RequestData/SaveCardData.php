<?php

namespace Sashalenz\MonobankApi\RequestData;

use Spatie\LaravelData\Data;

class SaveCardData extends Data
{
    public function __construct(
        public bool $saveCard,
        public ?string $walletId = null,
    ) {}
}
