<?php

namespace Sashalenz\MonobankApi\Enums;

enum PaymentType: string
{
    case DEBIT = 'debit';
    case HOLD = 'hold';
}
