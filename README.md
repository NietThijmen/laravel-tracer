# Laravel tracer

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nietthijmen/laravel-tracer.svg?style=flat-square)](https://packagist.org/packages/nietthijmen/laravel-tracer)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/nietthijmen/laravel-tracer/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/nietthijmen/laravel-tracer/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/nietthijmen/laravel-tracer/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/nietthijmen/laravel-tracer/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/nietthijmen/laravel-tracer.svg?style=flat-square)](https://packagist.org/packages/nietthijmen/laravel-tracer)


A package to log request of authenticated users by bundling and qualifying routes.


This package is inspired by [protonemedia/laravel-tracer](https://github.com/protonemedia/laravel-tracer)

## Installation

You can install the package via composer:

```bash
composer require nietthijmen/laravel-tracer
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-tracer-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-tracer-config"
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

- [Thijmen Rierink](https://github.com/NietThijmen)
- [All Contributors](../../contributors)

