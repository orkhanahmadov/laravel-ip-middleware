<?php

namespace Orkhanahmadov\LaravelIpMiddleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class IpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param array $allowedIp
     * @return mixed
     */
    public function handle($request, Closure $next, ...$allowedIp)
    {
        if (!app()->environment(config('ip-middleware.ignore_environments')) && !in_array($request->ip(), Arr::flatten($allowedIp))) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
