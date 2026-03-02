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
php artisan laravel-tracer:install
```


## Usage
The package has 2 middleware, aliased as: traceUser & qualify
The qualify middleware allows you to "overwrite" the route name used for tracing, this is useful for when multiple routes can be grouped together, for example: all routes related to a specific resource.

```php
Route::middleware(['auth', 'traceUser', 'qualify:resource'])->group(function () {
    Route::get('/resource', [ResourceController::class, 'index'])->name('resource.index');
    Route::get('/resource/{id}', [ResourceController::class, 'show'])->name('resource.show');
});
```

You can then use the `UserTrace` model to query the traces, for example:

```php
use NietThijmen\LaravelTracer\Models\UserTrace;
$traces = UserTrace::where('route_name', 'resource')->get();
```

There's also some configs for the package which get auto-published when you run the install command, you can find them in `config/tracer.php`
These configs allow you to set what gets traced (user agent, ip address, etc.) and also allow you to set a custom model for the traces.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Thijmen Rierink](https://github.com/NietThijmen)
- [All Contributors](../../contributors)

