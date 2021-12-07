# EU VAT library for laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bolivir/laravel-vat.svg?style=flat-square)](https://packagist.org/packages/bolivir/laravel-vat)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/bolivir/laravel-vat/run-tests?label=tests)](https://github.com/bolivir/laravel-vat/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/bolivir/laravel-vat/Check%20&%20fix%20styling?label=code%20style)](https://github.com/bolivir/laravel-vat/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/bolivir/laravel-vat.svg?style=flat-square)](https://packagist.org/packages/bolivir/laravel-vat)

Laravel VAT is a package to validate a VAT number for businesses based in Europe.

## Installation

You can install the package via composer:

```bash
composer require bolivir/laravel-vat
```

## Usage

### Validate VAT number format and existence
```php
$vat = new Bolivir\VAT();
echo $vat->validate('NL123456789B01');
// FALSE
```

### Validate VAT number format
```php
$vat = new Bolivir\VAT();
echo $vat->validateFormat('NL123456789B01');
// TRUE
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Ricardo Mosselman](https://github.com/bolivir)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
