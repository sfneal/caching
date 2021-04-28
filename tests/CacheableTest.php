<?php

namespace Sfneal\Caching\Tests;

use Sfneal\Caching\Tests\Mocks\TodaysDateHash;
use Sfneal\Helpers\Redis\RedisCache;

class CacheableTest extends TestCase
{
    /** @test */
    public function cache_key_is_correct()
    {
        $todaysDate = new TodaysDateHash();

        $this->assertNotNull($todaysDate->cacheKey());
        $this->assertIsString($todaysDate->cacheKey());
    }

    /** @test */
    public function values_can_be_cached()
    {
        $todaysDate = new TodaysDateHash();

        $output = $todaysDate->fetch();

        $this->assertTrue($todaysDate->isCached());
        $this->assertEquals(RedisCache::get($todaysDate->cacheKey()), $output);
    }

    /** @test */
    public function cache_can_be_invalidated()
    {
        $todaysDate = new TodaysDateHash();
        $todaysDate->fetch();

        $this->assertTrue($todaysDate->isCached());

        $todaysDate->invalidateCache();
        $this->assertFalse($todaysDate->isCached());
    }
}
