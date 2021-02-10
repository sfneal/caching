<?php

namespace Sfneal\Caching\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;
use Sfneal\Caching\Tests\Mocks\TodaysDateHash;
use Sfneal\Helpers\Redis\Providers\RedisHelpersServiceProvider;
use Sfneal\Helpers\Redis\RedisCache;

class CacheableTest extends TestCase
{
    /**
     * Register package service providers.
     *
     * @param Application $app
     * @return array|string
     */
    protected function getPackageProviders($app)
    {
        return RedisHelpersServiceProvider::class;
    }

    public function test_caching_is_working()
    {
        $todaysDate = new TodaysDateHash();
        $key = $todaysDate->cacheKey();

        $output = $todaysDate->fetch();

        $this->assertTrue(RedisCache::exists($key));
        $this->assertTrue(RedisCache::get($key) == $output);
    }
}
