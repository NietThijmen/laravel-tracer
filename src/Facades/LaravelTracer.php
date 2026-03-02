<?php

namespace Nietthijmen\LaravelTracer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nietthijmen\LaravelTracer\LaravelTracer
 */
class LaravelTracer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Nietthijmen\LaravelTracer\LaravelTracer::class;
    }
}
