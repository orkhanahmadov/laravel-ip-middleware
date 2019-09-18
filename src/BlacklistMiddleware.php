<?php

namespace Orkhanahmadov\LaravelIpMiddleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class BlacklistMiddleware extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param array $blacklist
     *
     * @return mixed
     */
    public function handle($request, Closure $next, ...$blacklist)
    {
        if ($this->shouldCheck() && in_array($this->realIp($request), Arr::flatten($blacklist))) {
            $this->application->abort($this->errorCode);
        }

        return $next($request);
    }
}
