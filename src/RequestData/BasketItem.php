<?php

namespace Sashalenz\MonobankApi\RequestData;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class BasketItem extends Data
{
    public function __construct(
        public string $name,
        public float $qty,
        public int $sum,
        public int $total,
        public ?string $icon = null,
        public ?string $unit = null,
        public ?string $code = null,
        public ?string $barcode = null,
        public ?string $header = null,
        public ?string $footer = null,
        /** @var int[]|null */
        public ?array $tax = null,
        public ?string $uktzed = null,
        #[DataCollectionOf(Discount::class)]
        public ?DataCollection $discounts = null,
    ) {}
}
