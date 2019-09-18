<?php

namespace Orkhanahmadov\LaravelIpMiddleware;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

abstract class Middleware
{
    /**
     * @var Application
     */
    protected $application;
    /**
     * @var Repository
     */
    protected $config;
    /**
     * @var int
     */
    protected $errorCode = Response::HTTP_FORBIDDEN;

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
        $this->errorCode = $config->get('ip-middleware.error_code');
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function realIp($request): string
    {
        return $request->server('HTTP_CF_CONNECTING_IP') ?? $request->ip();
    }

    /**
     * Return result if middleware should IP check.
     *
     * @return bool
     */
    protected function shouldCheck(): bool
    {
        return !$this->application->environment($this->config->get('ip-middleware.ignore_environments'));
    }
}
