<?php

namespace Sashalenz\MonobankApi\ApiModels;

use Illuminate\Support\Collection;
use Sashalenz\MonobankApi\Exceptions\MonobankApiException;
use Sashalenz\MonobankApi\ResponseData\CurrencyResponse;

class Bank extends BaseModel
{
    protected string $method = 'bank';

    /**
     * @throws MonobankApiException
     */
    public function currency(): Collection
    {
        return CurrencyResponse::collect(
            $this
                ->setMethod(__FUNCTION__)
                ->get()
        );
    }
}
