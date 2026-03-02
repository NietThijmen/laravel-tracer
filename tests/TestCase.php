<?php

namespace Nietthijmen\LaravelTracer\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nietthijmen\LaravelTracer\LaravelTracerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Workbench\App\Models\User;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Nietthijmen\\LaravelTracer\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelTracerServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../workbench/database/migrations');
    }

    protected function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
        config()->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Set default tracer config
        config()->set('tracer.log_ip_address', true);
        config()->set('tracer.log_user_agent', true);
        config()->set('tracer.log_referer', true);
    }

    /**
     * Create a test user for authentication tests.
     */
    protected function createUser(array $attributes = []): User
    {
        return User::create(array_merge([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ], $attributes));
    }
}
