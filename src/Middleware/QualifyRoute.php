<?php

namespace Nietthijmen\LaravelTracer\Middleware;

use Closure;
use Illuminate\Http\Request;

class QualifyRoute
{

    public function handle(
        Request $request,
        Closure $next,
        string $name,
        ?int $secondsBetweenLog = null
    )
    {
        $request->qualifyAs($name, $secondsBetweenLog);
        return $next($request);

    }

}
