<?php

namespace Nietthijmen\LaravelTracer\Commands;

use Illuminate\Console\Command;

class LaravelTracerCommand extends Command
{
    public $signature = 'laravel-tracer';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
