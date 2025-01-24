<?php

namespace Sashalenz\MonobankApi\ApiModels;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Sashalenz\MonobankApi\Exceptions\MonobankApiException;
use Sashalenz\MonobankApi\Request;
use Spatie\LaravelData\Data;

abstract class BaseModel
{
    private bool $canBeCached = false;

    private int $cacheSeconds = -1;

    private string $token = '';

    protected string $method = '';

    protected ?string $proxy = null;

    protected ?Data $params = null;

    protected function getHeaders(): array
    {
        return [
            'User-Agent' => 'CRM',
            'X-Token' => $this->token,
        ];
    }

    protected function setParams(Data $data): self
    {
        $this->params = $data;

        return $this;
    }

    protected function getParams(): array
    {
        if (is_null($this->params)) {
            return [];
        }

        return array_filter($this->params->toArray());
    }

    public function cache(int $seconds = -1): self
    {
        $this->canBeCached = true;
        $this->cacheSeconds = $seconds;

        return $this;
    }

    public function token(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function proxy(string $proxy): self
    {
        $this->proxy = $proxy;

        return $this;
    }

    /**
     * @throws MonobankApiException
     */
    protected function validate(array $rules = []): self
    {
        $validator = Validator::make(
            $this->getParams(),
            $rules
        );

        if ($validator->fails()) {
            throw new MonobankApiException('Validation exception '.$validator->errors()->first());
        }

        return $this;
    }

    protected function setMethod(string $method): self
    {
        $this->method = collect([$this->method])
            ->add($method)
            ->implode('/');

        return $this;
    }

    /**
     * @throws MonobankApiException
     */
    final protected function request(bool $isPost = false): Response
    {
        $request = new Request(
            method: $this->method,
            params: $this->getParams(),
            headers: $this->getHeaders(),
            isPost: $isPost,
            cache: $this->canBeCached
                ? $this->cacheSeconds
                : null,
        );

        return $request->make();
    }

    /**
     * @throws MonobankApiException
     */
    final protected function get(): Collection
    {
        return $this->request()->collect();
    }

    /**
     * @throws MonobankApiException
     */
    final protected function post(): Collection
    {
        return $this->request(
            isPost: true
        )->collect();
    }
}
