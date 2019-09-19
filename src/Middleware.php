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
     * @param array<string> $list
     *
     * @return array<string>
     */
    protected function ipList(array $list): array
    {
        $predefinedLists = $this->config->get('ip-middleware.predefined_lists');

        $finalList = [];
        foreach (Arr::flatten($list) as $item) {
            if (isset($predefinedLists[$item])) {
                $finalList[] = $this->parsePredefinedListItem($predefinedLists[$item]);
            } else {
                $finalList[] = $item;
            }
        }

        return Arr::flatten($finalList);
    }

    /**
     * @param array<string>|string $item
     *
     * @return array<string>
     */
    private function parsePredefinedListItem($item): array
    {
        if (is_array($item)) {
            return $item;
        }

        return explode(',', $item);
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
