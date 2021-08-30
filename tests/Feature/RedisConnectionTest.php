<?php

namespace Sfneal\Caching\Tests\Feature;

use Illuminate\Redis\Connections\PredisConnection;
use Illuminate\Support\Facades\Redis;
use Lunaweb\RedisMock\MockPredisConnection;
use Sfneal\Caching\Tests\TestCase;

class RedisConnectionTest extends TestCase
{
    public function test_redis_connection()
    {
        if (config('database.redis.client') == 'mock') {
            $this->assertInstanceOf(MockPredisConnection::class, Redis::connection());
        } elseif (config('database.redis.client') == 'predis') {
            $this->assertInstanceOf(PredisConnection::class, Redis::connection());
        }
    }

    public function test_set_and_get()
    {
        Redis::set('key', 'test');
        $this->assertEquals('test', Redis::get('key'));
    }

    public function test_pipeline()
    {
        Redis::pipeline(function ($pipe) {
            $pipe->set('key1', 'test1');
            $pipe->set('key2', 'test2');
        });

        $this->assertEquals('test2', Redis::get('key2'));
    }
}
