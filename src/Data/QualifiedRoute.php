<?php

namespace Nietthijmen\LaravelTracer\Data;

/**
 * A small storage wrapper around the route "name" and the "seconds between log" value.
 * This is used to store the route name and the seconds between log value together, so we
 */
class QualifiedRoute
{
    private string $name;

    private ?int $secondsBetweenLog = null;

    public function __construct(
        string $name,
        ?int $secondsBetweenLog = null
    ) {
        $this->name = $name;

        if ($secondsBetweenLog !== null) {
            $secondsBetweenLog = config('tracer.seconds_between_logs', null);
        }

        $this->secondsBetweenLog = $secondsBetweenLog;
    }

    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of secondsBetweenLog
     */
    public function getSecondsBetweenLog(): ?int
    {
        return $this->secondsBetweenLog;
    }
}
