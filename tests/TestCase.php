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

    /**
     * Set up the environment.
     *
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
    }
}
