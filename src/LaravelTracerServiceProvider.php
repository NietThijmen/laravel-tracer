<?php

namespace Nietthijmen\LaravelTracer;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Nietthijmen\LaravelTracer\Commands\LaravelTracerCommand;

class LaravelTracerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-tracer')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_tracer_table')
            ->hasCommand(LaravelTracerCommand::class);
    }
}
