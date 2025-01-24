<?php

namespace Sashalenz\MonobankApi\Types;

use Spatie\LaravelData\Data;

class Jar extends Data
{
    public function __construct(
        public string $id,
        public string $sendId,
        public string $title,
        public string $description,
        public int $currencyCode,
        public int $balance,
        public int $goal,
    ) {}
}
