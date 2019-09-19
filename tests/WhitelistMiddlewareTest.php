<?php

namespace Orkhanahmadov\LaravelIpMiddleware\Tests;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Orkhanahmadov\LaravelIpMiddleware\WhitelistMiddleware;

class WhitelistMiddlewareTest extends TestCase
{
    /**
     * @var WhitelistMiddleware
     */
    private $middleware;

    public function testBlocksIfIpIsNotWhitelisted()
    {
        $this->expectException(HttpException::class);

        $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '1.1.1.0']);

        $this->middleware->handle($request, function () {
        }, '1.1.1.1', '2.2.2.2');
    }

    public function testBlocksWithCustomErrorCode()
    {
        config()->set('ip-middleware.error_code', $errorCode = Response::HTTP_BAD_REQUEST);
        $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '1.1.1.0']);

        try {
            $this->middleware->handle($request, function () {
            }, '1.1.1.1', '2.2.2.2');
        } catch (HttpException $exception) {
            $this->assertSame($errorCode, $exception->getStatusCode());
        }
    }

    public function testAllowsWithCustomServerParameter()
    {
        config()->set('ip-middleware.custom_server_parameter', 'HTTP_CUSTOM_IP');
        $request = Request::create('/', 'GET', [], [], [], ['HTTP_CUSTOM_IP' => '2.1.1.1']);

        $result = $this->middleware->handle($request, function () {
            return true;
        }, '2.1.1.1');

        $this->assertTrue($result);
    }

    public function testAllowsIfIpIsWhitelisted()
    {
        $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '1.1.1.1']);

        $result = $this->middleware->handle($request, function () {
            return true;
        }, '1.1.1.1');

        $this->assertTrue($result);
    }

    public function testAllowsIfEnvironmentIsIgnored()
    {
        config()->set('ip-middleware.ignore_environments', ['testing']);
        $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '2.2.2.2']);

        $result = $this->middleware->handle($request, function () {
            return true;
        }, '1.1.1.1');

        $this->assertTrue($result);
    }

    public function testAllowsWithPreconfiguredLists()
    {
        config()->set('ip-middleware.lists', [
            'list-1' => '1.1.1.1,2.2.2.2',
            'list-2' => ['3.3.3.3', '4.4.4.4'],
            'list-3' => '5.5.5.5',
        ]);
        $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '4.4.4.4']);

        $result = $this->middleware->handle($request, function () {
            return true;
        }, 'list-1', 'list-2', 'list-3');

        $this->assertTrue($result);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->middleware = $this->app->make(WhitelistMiddleware::class);
    }
}
