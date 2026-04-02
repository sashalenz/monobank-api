<?php

namespace Sashalenz\MonobankApi\RequestData;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class MerchantPaymInfo extends Data
{
    public function __construct(
        public ?string $reference = null,
        public ?string $destination = null,
        public ?string $comment = null,
        /** @var string[]|null */
        public ?array $customerEmails = null,
        #[DataCollectionOf(BasketItem::class)]
        public ?DataCollection $basketOrder = null,
        #[DataCollectionOf(Discount::class)]
        public ?DataCollection $discounts = null,
    ) {}
}
