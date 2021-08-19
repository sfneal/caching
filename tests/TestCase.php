<?php

namespace Sfneal\Caching\Tests;

use Illuminate\Foundation\Application;
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
        $app['config']->set('app.debug', true);
        $app['config']->set('database.redis.client', 'mock');
        $app['config']->set('cache.default', 'redis');
        $app['config']->set('cache.prefix', 'redis-helpers');
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
