<?php

namespace Sashalenz\MonobankApi\RequestData;

use Spatie\LaravelData\Data;

class Discount extends Data
{
    public function __construct(
        public string $type,
        public string $mode,
        public float $value,
    ) {}
}
