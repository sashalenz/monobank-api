<?php

namespace Sashalenz\MonobankApi;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Sashalenz\MonobankApi\Exceptions\MonobankApiException;

final class Request
{
    private const int TIMEOUT = 10;

    private const int RETRY_TIMES = 3;

    private const int RETRY_SLEEP = 100;

    public function __construct(
        private readonly string $method,
        private readonly array $params,
        private readonly array $headers,
        private readonly bool $isPost,
        private readonly ?int $cache = null,
        private readonly ?string $proxy = null,
    ) {}

    /**
     * @throws MonobankApiException
     */
    final public function make(): Response
    {
        if (is_null($this->cache)) {
            return $this->request();
        }

        if ($this->cache === -1) {
            return Cache::rememberForever(
                $this->getCacheKey(),
                fn () => $this->request()
            );
        }

        return Cache::remember(
            $this->getCacheKey(),
            $this->cache,
            fn () => $this->request()
        );
    }

    /**
     * @throws MonobankApiException
     */
    private function request(): Response
    {
        try {
            return Http::timeout(self::TIMEOUT)
                ->retry(
                    self::RETRY_TIMES,
                    self::RETRY_SLEEP
                )
                ->baseUrl(config('monobank-api.api_url'))
                ->withHeaders($this->headers)
                ->when(
                    ! is_null($this->proxy),
                    fn ($request) => $request->withOptions([
                        'proxy' => $this->proxy,
                    ])
                )
                ->when(
                    $this->isPost,
                    fn ($request) => $request
                        ->asJson()
                        ->post(
                            $this->method,
                            $this->params
                        ),
                    fn ($request) => $request->get(
                        $this->method,
                        $this->params
                    ),
                )
                ->throw();
        } catch (RequestException $e) {
            throw new MonobankApiException('API Exception: '.$e->getMessage(), $e->getCode());
        }
    }

    private function getCacheKey(): string
    {
        return collect([
            'monobank_api',
            $this->method,
            base64_encode(serialize($this->params)),
        ])
            ->implode('_');
    }
}
