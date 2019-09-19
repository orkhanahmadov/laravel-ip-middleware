<?php

namespace Orkhanahmadov\LaravelIpMiddleware;

use Closure;
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
        if ($this->shouldCheck() && in_array($this->clientIp($request), $this->ipList($blacklist))) {
            $this->abort();
        }

        return $next($request);
    }
}
