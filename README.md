# This is my package monobank-api

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sashalenz/monobank-api.svg?style=flat-square)](https://packagist.org/packages/sashalenz/monobank-api)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/sashalenz/monobank-api/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/sashalenz/monobank-api/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/sashalenz/monobank-api/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/sashalenz/monobank-api/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/sashalenz/monobank-api.svg?style=flat-square)](https://packagist.org/packages/sashalenz/monobank-api)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

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

```php
$monobankApi = new Sashalenz\MonobankApi();
echo $monobankApi->echoPhrase('Hello, Sashalenz!');
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
