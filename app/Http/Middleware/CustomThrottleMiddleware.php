<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class CustomThrottleMiddleware
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle($request, Closure $next, $key, $maxAttempts = 60, $decayMinutes = 1)
    {
        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            return response('Too Many Attemps. Retry Again', 429);
        }

        $this->limiter->hit($key, $decayMinutes);

        return $next($request);
    }
}
