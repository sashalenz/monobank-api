# CLAUDE.md

This file provides guidance for AI assistants working on the `sashalenz/monobank-api` codebase.

## Project Overview

A lightweight Laravel package that wraps the [Monobank API](https://api.monobank.ua/). It provides a fluent, type-safe PHP interface for fetching currency rates, client account info, statements, and managing webhooks.

- **Package**: `sashalenz/monobank-api`
- **PHP**: `^8.2`
- **Laravel**: `^10.0 || ^11.0 || ^12.0`
- **License**: MIT

## Development Commands

```bash
composer install          # Install dependencies
composer test             # Run Pest test suite
composer test-coverage    # Run tests with coverage report
composer analyse          # Run PHPStan static analysis (level 5)
composer format           # Auto-format code with Laravel Pint
```

## Repository Structure

```
src/
├── ApiModels/
│   ├── BaseModel.php              # Abstract base — HTTP, caching, proxy, validation
│   ├── Bank.php                   # Public API endpoints (no auth required)
│   └── Personal.php               # Authenticated API endpoints (token required)
├── Enums/
│   ├── AccountType.php            # black, white, platinum, iron, fop, yellow
│   └── CashbackType.php           # None, UAH, Miles
├── Exceptions/
│   └── MonobankApiException.php   # Single custom exception for all API errors
├── Http/
│   ├── Controllers/
│   │   └── WebhookController.php  # Receives incoming Monobank webhook payloads
│   └── Requests/
│       └── WebhookRequest.php     # Form request — validates webhook IP allowlist
├── RequestData/
│   └── WebhookRequest.php         # Spatie Data DTO for outgoing webhook registration
├── ResponseData/
│   ├── CurrencyResponse.php       # Exchange rate DTO
│   ├── ClientInfoResponse.php     # Client info + Account + Jar collections
│   └── StatementResponse.php      # Transaction statement DTO
├── Types/
│   ├── Account.php                # Account type (balance, IBAN, cards, limits)
│   └── Jar.php                    # Jar/savings goal type
├── MonobankApi.php                # Entry-point facade: MonobankApi::bank() / ::personal()
├── MonobankApiServiceProvider.php # Laravel service provider (registers config + route)
└── Request.php                    # HTTP layer — timeout, retries, caching, proxy

config/
└── monobank-api.php               # Package config (api_url, webhook_domain/key/ips)

routes/
└── web.php                        # Registers the webhook endpoint

tests/
├── Pest.php                       # Pest bootstrap — binds TestCase
├── TestCase.php                   # Orchestra Testbench base test case
├── ArchTest.php                   # Architecture rule: no dd/dump/ray in src
├── ExampleTest.php                # Sanity test
├── AccountTypeTest.php            # AccountType enum values
├── CashbackTypeTest.php           # CashbackType enum values
├── RequestProxyTest.php           # Proxy support in HTTP layer
├── StatementValidationTest.php    # Date validation in Personal::statement()
└── WebhookRequestTest.php         # IP allowlist in WebhookRequest form request
```

## Architecture Patterns

### Entry Point
`MonobankApi` is a thin static facade with two factory methods:
- `MonobankApi::bank()` — returns a `Bank` instance for public (unauthenticated) endpoints
- `MonobankApi::personal()` — returns a `Personal` instance for authenticated endpoints

### BaseModel (Fluent Builder)
All API model classes extend `BaseModel`, which provides a chainable builder interface:

```php
MonobankApi::personal()
    ->token('your-api-token')
    ->cache(300)              // cache for 300 seconds; cache(-1) = forever
    ->proxy('http://...')     // optional proxy
    ->clientInfo();
```

Key `BaseModel` internals:
- `setMethod(string $method)` — appends path segments using `/` separator
- `setParams(Data $data)` — attaches a Spatie Data DTO as request params
- `validate(array $rules)` — runs Laravel Validator; throws `MonobankApiException` on failure
- `get()` / `post()` — final methods that dispatch the `Request` and return a `Collection`

### HTTP Layer (`Request.php`)
- **Timeout**: 10 seconds
- **Retries**: 3 attempts, 100ms sleep between retries
- **Cache key**: `monobank_api_{method}_{base64(serialized(params))}`
- **Caching**: `null` = no cache; `-1` = `Cache::rememberForever`; `N` = `Cache::remember(N)`
- HTTP errors are caught as `RequestException` and re-thrown as `MonobankApiException`

### DTOs (Spatie Laravel Data)
- Response classes in `ResponseData/` extend `Spatie\LaravelData\Data`
- Use `::from(Collection)` for single objects, `::collect(Collection)` for lists
- `#[DataCollectionOf(ClassName::class)]` attribute for typed nested collections
- `#[WithCast(...)]` attribute for type coercion (e.g., Unix timestamp → Carbon)

### Webhook Flow
1. Monobank POSTs to the route registered in `routes/web.php` (key: `MONOBANK_WEBHOOK_KEY`)
2. `WebhookRequest` form request validates the source IP against `MONOBANK_WEBHOOK_IPS`
3. `WebhookController` receives the validated payload and logs it via `info()`

## Configuration

Published via `php artisan vendor:publish`. Key environment variables:

| Variable | Default | Description |
|---|---|---|
| `MONOBANK_API_URL` | `https://api.monobank.ua/` | Base API URL |
| `MONOBANK_WEBHOOK_DOMAIN` | — | Domain for webhook URL construction |
| `MONOBANK_WEBHOOK_KEY` | `webhook` | Route key/slug for the webhook endpoint |
| `MONOBANK_WEBHOOK_IPS` | `` | Comma-separated IP allowlist for webhook requests |

## Code Conventions

- **PHP 8.2+** — use constructor property promotion, enums, readonly where appropriate
- **Strict types** — all properties and method signatures must be type-hinted
- **Naming**: classes PascalCase, methods camelCase, no abbreviations
- **No debug functions** — `dd()`, `dump()`, `ray()` are banned (enforced by `ArchTest`)
- **Exceptions** — always throw `MonobankApiException`; document with `@throws` PHPDoc
- **No `is_null(x)` when `$x === null` is clearer** — follow existing style in the file
- **Fluent methods** return `self`; terminal methods return typed values (`Collection`, DTO, `bool`)
- **Conditionable trait** — use `->when()` for conditional branching in builders

## Testing

Tests use [Pest PHP v3](https://pestphp.com/) with Orchestra Testbench for Laravel integration.

```bash
composer test              # Run all tests
composer test-coverage     # With HTML/text coverage
vendor/bin/pest --ci       # CI mode (used in GitHub Actions)
```

When adding a new API method or feature:
1. Add a unit test in `tests/`
2. Ensure `ArchTest` still passes (no debug functions)
3. Run `composer analyse` to pass PHPStan level 5
4. Run `composer format` to apply Pint formatting before committing

## CI/CD

GitHub Actions workflows in `.github/workflows/`:

| Workflow | Trigger | What it does |
|---|---|---|
| `run-tests.yml` | push/PR | Pest tests on PHP 8.3/8.4 × Laravel 10/11 matrix |
| `phpstan.yml` | push (PHP files) | PHPStan level 5 static analysis |
| `fix-php-code-style-issues.yml` | push | Auto-runs Pint and commits fixes |
| `update-changelog.yml` | release | Updates CHANGELOG.md |
| `dependabot-auto-merge.yml` | Dependabot PRs | Auto-merges minor/patch updates |

## Adding New API Endpoints

Follow this pattern:

1. **Public endpoint** → add a method to `Bank` (no token required)
2. **Authenticated endpoint** → add a method to `Personal` (requires `.token()`)
3. Build the URL path using `setMethod()` calls (each call appends a segment)
4. For POST requests, create a DTO in `RequestData/`, call `setParams()`, then `post()`
5. For GET requests, call `get()` directly
6. Create a typed DTO in `ResponseData/` extending `Spatie\LaravelData\Data`
7. Use `::from()` for single-object responses, `::collect()` for list responses
8. Throw `MonobankApiException` for all error cases; document with `@throws`
9. Write a corresponding Pest test

**Example skeleton:**

```php
// In Personal.php
public function newEndpoint(string $param): SomeResponse
{
    return SomeResponse::from(
        $this
            ->setMethod('new-endpoint')
            ->setMethod($param)
            ->get()
    );
}
```
