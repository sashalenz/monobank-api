<?php

namespace Sashalenz\MonobankApi\ApiModels;

use Sashalenz\MonobankApi\Exceptions\MonobankApiException;
use Sashalenz\MonobankApi\RequestData\InvoiceData;
use Sashalenz\MonobankApi\ResponseData\InvoiceResponse;

class Acquiring extends BaseModel
{
    protected string $method = 'api/merchant';

    /**
     * @throws MonobankApiException
     */
    public function createInvoice(InvoiceData $data): InvoiceResponse
    {
        return InvoiceResponse::from(
            $this
                ->setMethod('invoice')
                ->setMethod('create')
                ->setParams($data)
                ->post()
        );
    }
}
