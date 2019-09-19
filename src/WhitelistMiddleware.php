<?php

namespace Orkhanahmadov\LaravelIpMiddleware;

use Closure;
use Illuminate\Http\Request;

class WhitelistMiddleware extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param array $whitelist
     *
     * @return mixed
     */
    public function handle($request, Closure $next, ...$whitelist)
    {
        if ($this->shouldCheck() && ! in_array($this->clientIp($request), $this->ipList($whitelist))) {
            $this->abort();
        }

        return $next($request);
    }
}
