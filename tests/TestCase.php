<?php

namespace Sfneal\Caching\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Support\Facades\Cache;
use Lunaweb\RedisMock\Providers\RedisMockServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Sfneal\Caching\Tests\Assets\AutoKeyPoundConverter;
use Sfneal\Caching\Tests\Assets\DateHash;
use Sfneal\Caching\Tests\Assets\DollarConverter;
use Sfneal\Caching\Tests\Assets\EuroConverter;
use Sfneal\Caching\Tests\Assets\PoundConverter;
use Sfneal\Helpers\Redis\Providers\RedisHelpersServiceProvider;

class TestCase extends OrchestraTestCase
{
    /**
     * Define environment setup.
     *
     * @param  Application  $app
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
     * @param  Application  $app
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
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        Cache::flush();
    }

    /**
     * Retrieve an array of arguments to pass to `DateHash` constructor.
     *
     * @return array[]
     */
    public static function cacheablesProvider(): array
    {
        return [
            'DateHash_1' => [new DateHash(now()->subDay(), 'Y-m-d')],
            'DateHash_2' => [new DateHash(now()->subDay(), 'm/d/Y')],
            'DateHash_3' => [new DateHash(now()->subDay(), 'm/d/y')],
            'DateHash_4' => [new DateHash(now(), 'Y-m-d')],
            'DateHash_5' => [new DateHash(now(), 'm/d/Y')],
            'DateHash_6' => [new DateHash(now(), 'm/d/y')],
            'DateHash_7' => [new DateHash(now()->addDay(), 'Y-m-d')],
            'DateHash_8' => [new DateHash(now()->addDay(), 'm/d/Y')],
            'DateHash_9' => [new DateHash(now()->addDay(), 'm/d/y')],
            'EuroConverter_1' => [new EuroConverter(rand(0, 1000))],
            'EuroConverter_2' => [new EuroConverter(rand(0, 1000))],
            'EuroConverter_3' => [new EuroConverter(rand(0, 1000))],
            'PoundConverter_1' => [new PoundConverter(rand(0, 1000))],
            'PoundConverter_2' => [new PoundConverter(rand(0, 1000))],
            'PoundConverter_3' => [new PoundConverter(rand(0, 1000))],
            'DollarConverter_1' => [new DollarConverter(rand(0, 1000))],
            'DollarConverter_2' => [new DollarConverter(rand(0, 1000))],
            'DollarConverter_3' => [new DollarConverter(rand(0, 1000))],
            'AutoKeyPoundConverter' => [new AutoKeyPoundConverter(rand(0, 1000))],
        ];
    }
}
