<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Cache\RateLimiter;

class RateLimitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
        */
    protected $limiter;

     public function __construct(RateLimiter $limiter)
     {
         $this->limiter = $limiter;
     }
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        
        // Rate limiting for each IP address
        $key = 'rate_limit:' . $ip;
        if ($this->limiter->tooManyAttempts($key, 1)) {
            return response()->json(['message' => 'Another session is already in progress.'], 403);
        }

        $this->limiter->hit($key, 1);

        return $next($request);
    }
}
