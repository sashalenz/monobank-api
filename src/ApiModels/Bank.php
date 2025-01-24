<?php

namespace Sashalenz\MonobankApi\ApiModels;

use Sashalenz\MonobankApi\Exceptions\MonobankApiException;
use Sashalenz\MonobankApi\ResponseData\CurrencyResponse;

class Bank extends BaseModel
{
    protected string $method = 'bank';

    /**
     * @throws MonobankApiException
     */
    public function settings():CurrencyResponse
    {
        return CurrencyResponse::from(
            $this
                ->setMethod(__FUNCTION__)
                ->get()
        );
    }
}
