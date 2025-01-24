<?php

namespace Sashalenz\MonobankApi\ApiModels;

use Sashalenz\MonobankApi\Exceptions\MonobankApiException;
use Sashalenz\MonobankApi\RequestData\WebhookRequest;
use Sashalenz\MonobankApi\ResponseData\ClientInfoResponse;
use Sashalenz\MonobankApi\ResponseData\StatementResponse;

class Personal extends BaseModel
{
    protected string $method = 'personal';

    /**
     * @throws MonobankApiException
     */
    public function clientInfo(): ClientInfoResponse
    {
        return ClientInfoResponse::from(
            $this
                ->setMethod('client-info')
                ->get()
        );
    }

    /**
     * @throws MonobankApiException
     */
    public function webhook(string $webHookUrl): bool
    {
        return $this
            ->setMethod(__FUNCTION__)
            ->setParams(new WebhookRequest(
                webHookUrl: $webHookUrl
            ))
            ->request()
            ->getStatusCode() === 200;
    }

    /**
     * @throws MonobankApiException
     */
    public function statement(string $account, int $dateFrom, int $dateTo): string
    {
        if ($dateFrom > $dateTo) {
            throw new MonobankApiException('Date from must be less than date to');
        }

        if ($dateTo > $dateFrom + 2682000) {
            throw new MonobankApiException('Date to must be less than 31 days');
        }

        return StatementResponse::collect(
            $this
                ->setMethod(__FUNCTION__)
                ->setMethod($account)
                ->setMethod((string) $dateFrom)
                ->setMethod((string) $dateTo)
                ->get()
        );
    }
}
