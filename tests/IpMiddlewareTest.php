<?php

namespace Orkhanahmadov\LaravelIpMiddleware\Tests;

use Illuminate\Http\Request;
use Orkhanahmadov\LaravelIpMiddleware\IpMiddleware;
use Symfony\Component\HttpKernel\Exception\HttpException;

class IpMiddlewareTest extends TestCase
{
    public function testFails()
    {
        $this->withoutExceptionHandling();
        $this->expectException(HttpException::class);
        $middleware = $this->app->make(IpMiddleware::class);
        $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '1.1.1.0']);

        $middleware->handle($request, function () {
        }, '1.1.1.1');
    }

    public function testPasses()
    {
        $this->withoutExceptionHandling();
        $middleware = new IpMiddleware();
        $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '1.1.1.1']);

        $middleware->handle($request, function () {
        }, '1.1.1.1');
    }
}
