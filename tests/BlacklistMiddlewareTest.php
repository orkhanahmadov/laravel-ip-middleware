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

    public function testBlocksIfIpIsBlacklisted()
    {
        $this->expectException(HttpException::class);

        $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '1.1.1.1']);

        $this->middleware->handle($request, function () {
        }, '1.1.1.1', '2.2.2.2');
    }

    public function testBlocksWithCustomServerParameter()
    {
        $this->expectException(HttpException::class);

        config()->set('ip-middleware.custom_server_parameter', 'HTTP_CUSTOM_IP');
        $request = Request::create('/', 'GET', [], [], [], ['HTTP_CUSTOM_IP' => '1.1.1.1']);

        $this->middleware->handle($request, function () {
        }, '1.1.1.1');
    }

    public function testAllowsIfIpIsNotBlacklisted()
    {
        $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '2.2.2.2']);

        $result = $this->middleware->handle($request, function () {
            return true;
        }, '1.1.1.1');

        $this->assertTrue($result);
    }

    public function testAllowsIfEnvironmentIsIgnored()
    {
        config()->set('ip-middleware.ignore_environments', ['testing']);
        $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '1.1.1.1']);

        $result = $this->middleware->handle($request, function () {
            return true;
        }, '1.1.1.1');

        $this->assertTrue($result);
    }

    public function testBlocksWithPreconfiguredLists()
    {
        $this->expectException(HttpException::class);

        config()->set('ip-middleware.lists', [
            'list-1' => '1.1.1.1,2.2.2.2',
            'list-2' => ['3.3.3.3', '4.4.4.4'],
            'list-3' => '5.5.5.5',
        ]);
        $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '4.4.4.4']);

        $this->middleware->handle($request, function () {
        }, 'list-1', 'list-2', 'list-3');
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->middleware = $this->app->make(BlacklistMiddleware::class);
    }
}
