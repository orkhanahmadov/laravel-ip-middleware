<?php

namespace Orkhanahmadov\LaravelIpMiddleware\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as Orchestra;
use Orkhanahmadov\LaravelIpMiddleware\LaravelIpMiddlewareServiceProvider;

class TestCase extends Orchestra
{
    /**
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelIpMiddlewareServiceProvider::class,
        ];
    }
}
