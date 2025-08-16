# Monobank API client for PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sashalenz/monobank-api.svg?style=flat-square)](https://packagist.org/packages/sashalenz/monobank-api)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/sashalenz/monobank-api/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/sashalenz/monobank-api/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/sashalenz/monobank-api/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/sashalenz/monobank-api/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/sashalenz/monobank-api.svg?style=flat-square)](https://packagist.org/packages/sashalenz/monobank-api)

A lightweight and expressive PHP wrapper for the [Monobank API](https://api.monobank.ua/).
It provides simple methods for accessing public banking information and personal
account data.

## Installation

You can install the package via composer:

```bash
composer require sashalenz/monobank-api
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="monobank-api-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

This package provides helpers for all Monobank API requests:

- `MonobankApi::bank()->currency()` – get current currency exchange rates.
- `MonobankApi::personal()->clientInfo()` – retrieve information about accounts and cards.
- `MonobankApi::personal()->webhook($url)` – register a webhook URL for transaction updates.
- `MonobankApi::personal()->statement($account, $dateFrom, $dateTo = null)` – fetch a statement for a specific account and period.

### Examples

#### Currency rates
Retrieve public exchange rates without authentication.

```php
use Sashalenz\MonobankApi\MonobankApi;

$rates = MonobankApi::bank()->currency();

foreach ($rates as $rate) {
    echo $rate->currencyCodeA . ' => ' . $rate->rateBuy . PHP_EOL;
}
```

#### Client information
Get information about your accounts and cards.

```php
$info = MonobankApi::personal()->token($token)->clientInfo();
```

#### Register webhook
Configure a webhook to receive transaction updates.

```php
MonobankApi::personal()->token($token)->webhook('https://example.com/monobank');
```

#### Account statement
Fetch the statement for an account within a given period.

```php
$statement = MonobankApi::personal()
    ->token($token)
    ->statement($accountId, $dateFrom, $dateTo);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [sashalenz](https://github.com/sashalenz)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
