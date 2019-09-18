<?php

namespace Orkhanahmadov\LaravelIpMiddleware;

use Illuminate\Support\ServiceProvider;

/**
 * @codeCoverageIgnore
 */
class LaravelIpMiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('ip-middleware.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'ip-middleware');
    }
}
