<?php

namespace Sashalenz\MonobankApi\RequestData;

use Sashalenz\MonobankApi\Enums\PaymentType;
use Spatie\LaravelData\Data;

class InvoiceData extends Data
{
    public function __construct(
        public int $amount,
        public ?int $ccy = null,
        public ?MerchantPaymInfo $merchantPaymInfo = null,
        public ?string $redirectUrl = null,
        public ?string $webHookUrl = null,
        public ?int $validity = null,
        public ?PaymentType $paymentType = null,
        public ?string $qrId = null,
        public ?string $code = null,
        public ?SaveCardData $saveCardData = null,
    ) {}
}
