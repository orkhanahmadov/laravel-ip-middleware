<?php

namespace Orkhanahmadov\LaravelIpMiddleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;

class IpMiddleware
{
    /**
     * @var Application
     */
    private $application;
    /**
     * @var Repository
     */
    private $config;

    /**
     * IpMiddleware constructor.
     *
     * @param Application $application
     * @param Repository $config
     */
    public function __construct(Application $application, Repository $config)
    {
        $this->application = $application;
        $this->config = $config;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param array $allowedIp
     *
     * @return mixed
     */
    public function handle($request, Closure $next, ...$allowedIp)
    {
        $clientIp = $request->server('HTTP_CF_CONNECTING_IP') ?? $request->ip();

        if (! $this->application->environment($this->config->get('ip-middleware.ignore_environments')) &&
            ! in_array($clientIp, Arr::flatten($allowedIp))
        ) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
