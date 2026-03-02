<?php

namespace Nietthijmen\LaravelTracer;

use Illuminate\Http\Request;
use Nietthijmen\LaravelTracer\Data\QualifiedRoute;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->setName('laravel-tracer:install')
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('nietthijmen/laravel-tracer?utm_source=package');
            });
    }

    public function boot(): void
    {
        parent::boot();
        $this->app['router']->aliasMiddleware('traceUser', Middleware\TraceUser::class);
        $this->app['router']->aliasMiddleware('qualify', Middleware\QualifyRoute::class);
    }

    public function register(): void
    {
        parent::register();
        Request::macro('qualifyAs', function (string $name, ?int $secondsBetweenLog = null) {
            $this->route = new QualifiedRoute($name, $secondsBetweenLog);

            return $this;
        });

        Request::macro('qualifiedAs', function (): QualifiedRoute {
            return $this->route ?? new QualifiedRoute($this->route()->getName() ?? 'generic-route');
        });
    }
}
