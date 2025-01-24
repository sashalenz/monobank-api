<?php

namespace Sashalenz\MonobankApi;

use Sashalenz\MonobankApi\ApiModels\Bank;
use Sashalenz\MonobankApi\ApiModels\Personal;

class MonobankApi {
    public static function bank(): Bank
    {
        return new Bank();
    }

    public static function personal(): Personal
    {
        return new Personal();
    }
}
