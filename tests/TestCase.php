<?php

namespace Sfneal\Caching\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Lunaweb\RedisMock\Providers\RedisMockServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
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
    public function dateHashParamsProvider(): array
    {
        return [
            [now()->subDay(), 'Y-m-d'],
            [now()->subDay(), 'm/d/Y'],
            [now()->subDay(), 'm/d/y'],
            [now(), 'Y-m-d'],
            [now(), 'm/d/Y'],
            [now(), 'm/d/y'],
            [now()->addDay(), 'Y-m-d'],
            [now()->addDay(), 'm/d/Y'],
            [now()->addDay(), 'm/d/y'],
        ];
    }
}
