<?php

namespace Sfneal\Caching\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Lunaweb\RedisMock\Providers\RedisMockServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Sfneal\Caching\Tests\Assets\DateHash;
use Sfneal\Helpers\Redis\Providers\RedisHelpersServiceProvider;

class TestCase extends OrchestraTestCase
{
    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // make sure, our .env file is loaded
        $app->useEnvironmentPath(__DIR__.'/..');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);

        $app['config']->set('app.debug', true);
        $app['config']->set('cache.default', 'redis');
        $app['config']->set('cache.prefix', 'redis-helpers');

        $app['config']->set('database.redis.client', env('REDIS_CLIENT', 'mock'));
        $app['config']->set('database.redis.default.host', env('REDIS_HOST', '127.0.0.1'));
        $app['config']->set('database.redis.default.port', env('REDIS_PORT', 6379));
        $app['config']->set('database.redis.default.options.prefix', null);
        $app['config']->set('cache.stores.redis.connection', 'default');
    }

    /**
     * Register package service providers.
     *
     * @param Application $app
     * @return array|string
     */
    protected function getPackageProviders($app)
    {
        return [
            RedisHelpersServiceProvider::class,
            RedisMockServiceProvider::class,
        ];
    }

    /**
     * Retrieve an array of arguments to pass to `DateHash` constructor.
     *
     * @return array[]
     */
    public function cacheablesProvider(): array
    {
        return [
            [new DateHash(now()->subDay(), 'Y-m-d')],
            [new DateHash(now()->subDay(), 'm/d/Y')],
            [new DateHash(now()->subDay(), 'm/d/y')],
            [new DateHash(now(), 'Y-m-d')],
            [new DateHash(now(), 'm/d/Y')],
            [new DateHash(now(), 'm/d/y')],
            [new DateHash(now()->addDay(), 'Y-m-d')],
            [new DateHash(now()->addDay(), 'm/d/Y')],
            [new DateHash(now()->addDay(), 'm/d/y')],
        ];
    }
}
