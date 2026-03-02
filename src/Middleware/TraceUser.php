<?php

namespace Nietthijmen\LaravelTracer\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Nietthijmen\LaravelTracer\Data\QualifiedRoute;
use Nietthijmen\LaravelTracer\Models\UserTrace;

/**
 * This is the primary class to trace the route and user information. It will be used to trace the route and user information, and it will be used to store the route and user information in the database.
 */
class TraceUser
{
    private RateLimiter $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(
        Request $request,
        Closure $next
    ) {
        $response = $next($request);

        if (! $user = $request->user()) {
            return $response;
        }

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            return $response;
        }

        $this->traceRequest(
            $user,
            $request
        );

        return $response;
    }

    /**
     * @return array{
     *     'user_id': int|string,
     *     'qualified_route': string,
     *     'ip_address': string|null,
     *     'user_agent': string|null,
     *     'referer': string|null,
     * }
     */
    private function getDataToLog(
        Authenticatable $user,
        Request $request,
    ): array {
        $data = [
            'user_id' => $user->getAuthIdentifier(),
            'qualified_route' => $request->qualifiedAs()->getName(),
        ];

        if (config('tracer.log_ip_address')) {
            $data['ip_address'] = $request->ip();
        }

        if (config('tracer.log_user_agent')) {
            $data['user_agent'] = $request->userAgent();
        }

        if (config('tracer.log_referer')) {
            $data['referer'] = $request->headers->get('referer');
        }

        return $data;
    }

    /**
     * Stores the user request in the database.
     */
    private function traceRequest(Authenticatable $user, Request $request): ?UserTrace
    {
        $qualified = $request->qualifiedAs();

        if (! $this->shouldLog($qualified, $request)) {
            return null;
        }

        $data = $this->getDataToLog(
            $user,
            $request,
        );

        return UserTrace::create($data);
    }

    /**
     * Determines if the user request should be traced based on the request and response.
     */
    private function shouldLog(
        QualifiedRoute $qualified,
        Request $request
    ): bool
    {
        if (! $secondsBetweenLogs = $qualified->getSecondsBetweenLog()) {
            return true;
        }

        $name = "{$qualified->getName()}|tracer|user:{$request->user()->getAuthIdentifier()}";

        if ($this->limiter->tooManyAttempts($name, 1)) {
            return false;
        }

        $this->limiter->hit($name, $secondsBetweenLogs);

        return true;
    }
}
