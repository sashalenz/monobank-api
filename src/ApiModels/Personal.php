<?php

namespace Sashalenz\MonobankApi\ApiModels;

use Illuminate\Support\Collection;
use Sashalenz\MonobankApi\Exceptions\MonobankApiException;
use Sashalenz\MonobankApi\RequestData\WebhookData;
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
     * Реєструє webhook URL у Monobank для статементів. Monobank приймає
     * `POST /personal/webhook` з body `{"webHookUrl": "..."}` — GET повертає 405.
     *
     * @throws MonobankApiException
     */
    public function webhook(string $webHookUrl): bool
    {
        return $this
            ->setMethod(__FUNCTION__)
            ->setParams(new WebhookData(
                webHookUrl: $webHookUrl
            ))
            ->request(isPost: true)
            ->getStatusCode() === 200;
    }

    /**
     * @throws MonobankApiException
     */
    public function statement(string $account, int $dateFrom, ?int $dateTo = null): Collection
    {
        if (! is_null($dateTo) && $dateFrom > $dateTo) {
            throw new MonobankApiException('Date from must be less than date to');
        }

        if (! is_null($dateTo) && $dateTo > $dateFrom + 2682000) {
            throw new MonobankApiException('Date to must be less than 31 days');
        }

        return StatementResponse::collect(
            $this
                ->setMethod(__FUNCTION__)
                ->setMethod($account)
                ->setMethod((string) $dateFrom)
                ->when(
                    ! is_null($dateTo),
                    fn ($request) => $request->setMethod((string) $dateTo),
                )
                ->get()
        );
    }
}
