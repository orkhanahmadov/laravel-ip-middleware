<?php

namespace Orkhanahmadov\LaravelIpMiddleware\Tests;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Orkhanahmadov\LaravelIpMiddleware\BlacklistMiddleware;
use Orkhanahmadov\LaravelIpMiddleware\WhitelistMiddleware;

class BlacklistMiddlewareTest extends TestCase
{
    /**
     * @var WhitelistMiddleware
     */
    private $middleware;

    public function testBlocksIfIpIsBlacklist()
    {
        $this->expectException(HttpException::class);
        $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '1.1.1.1']);

        $this->middleware->handle($request, function () {
        }, '1.1.1.1', '2.2.2.2');
    }

    public function testBlocksWithCustomIpParameter()
    {
        $this->expectException(HttpException::class);
        app()['config']->set('ip-middleware.custom_server_parameter', 'HTTP_CUSTOM_IP');
        $request = Request::create('/', 'GET', [], [], [], ['HTTP_CUSTOM_IP' => '2.1.1.1']);

        $this->middleware->handle($request, function () {
        }, '2.1.1.1');
    }

    public function testAllowsIfIpIsNotBlocklisted()
    {
        $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '2.1.1.1']);

        $result = $this->middleware->handle($request, function () {
            return true;
        }, '1.1.1.1');

        $this->assertTrue($result);
    }

    public function testAllowsIfEnvironmentIsIgnored()
    {
        app()['config']->set('ip-middleware.ignore_environments', ['testing']);
        $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '1.1.1.1']);

        $result = $this->middleware->handle($request, function () {
            return true;
        }, '1.1.1.1');

        $this->assertTrue($result);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->middleware = $this->app->make(BlacklistMiddleware::class);
    }
}
