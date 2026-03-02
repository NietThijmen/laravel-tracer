<?php

namespace Nietthijmen\LaravelTracer;

use Illuminate\Http\Request;
use Nietthijmen\LaravelTracer\Data\QualifiedRoute;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Nietthijmen\LaravelTracer\Commands\LaravelTracerCommand;

class LaravelTracerServiceProvider extends PackageServiceProvider
{

    private QualifiedRoute $route;

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
            ->hasMigration('create_user_traces_table')
            ->hasCommand(LaravelTracerCommand::class)
            ->hasInstallCommand(static function(InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('nietthijmen/laravel-tracer?utm_source=package')
                    ->info("Thank you for installing Laravel Tracer! I'd recommend opening the documentation to get started:");
            });
    }

    public function register(): void
    {
        Request::macro('qualifyAs', static function (string $name, ?int $secondsBetweenLog = null) {
            $this->route = new QualifiedRoute($name, $secondsBetweenLog);
            return $this;
        });

        Request::macro('qualifiedAs', static function (): QualifiedRoute {
            return $this->route ?? new QualifiedRoute($this->route()->getName() ?? 'generic-route');
        });

        $this->app['router']->aliasMiddleware('traceUser', Middleware\TraceUser::class);
        $this->app['router']->aliasMiddleware('qualify', Middleware\QualifyRoute::class);
    }
}
