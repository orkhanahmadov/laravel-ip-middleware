<?php

namespace Orkhanahmadov\LaravelIpMiddleware;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;

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
     * Middleware constructor.
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
     * Returns client IP address.
     *
     * @param Request $request
     * @return string
     */
    protected function clientIp($request): string
    {
        return $request->server->get($this->config->get('ip-middleware.custom_server_parameter')) ?? $request->ip();
    }

    /**
     * Return result if middleware should IP check.
     *
     * @return bool
     */
    protected function shouldCheck(): bool
    {
        return ! $this->application->environment($this->config->get('ip-middleware.ignore_environments'));
    }

    /**
     * Returns IP address list parsed from original middleware parameter.
     *
     * @param array $list
     *
     * @return array
     */
    protected function ipList(array $list): array
    {
        $originalList = Arr::flatten($list);
        $preconfiguredLists = $this->config->get('ip-middleware.lists');

        $finalList = [];

        foreach ($originalList as $item) {
            if (! isset($preconfiguredLists[$item])) {
                $finalList[] = $item;
            } else {
                if (is_array($preconfiguredLists[$item])) {
                    $ipAddresses = $preconfiguredLists[$item];
                } else {
                    $ipAddresses = explode(',', $preconfiguredLists[$item]);
                }
                $finalList[] = $ipAddresses;
            }
        }

        return Arr::flatten($finalList);
    }

    /**
     * Aborts application with configured error code.
     */
    protected function abort()
    {
        return $this->application->abort(
            $this->config->get('ip-middleware.error_code')
        );
    }
}
