<?php

namespace Sashalenz\MonobankApi\Enums;

enum Currency: int
{
    case UAH = 980;

    public function code(): string
    {
        return match($this)
        {
            self::UAH => 'UAH'
        };
    }
}
