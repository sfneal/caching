<?php

namespace Sfneal\Caching\Tests;

use Sfneal\Caching\Tests\Mocks\TodaysDateHash;
use Sfneal\Helpers\Redis\RedisCache;

class CacheableTest extends TestCase
{
    public function test_caching_is_working()
    {
        $todaysDate = new TodaysDateHash();
        $key = $todaysDate->cacheKey();

        $output = $todaysDate->fetch();

        $this->assertTrue($todaysDate->isCached());
        $this->assertTrue(RedisCache::get($key) == $output);
    }
}
