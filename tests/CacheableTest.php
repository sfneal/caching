<?php

namespace Sfneal\Caching\Tests;

use Illuminate\Support\Facades\Cache;
use Sfneal\Caching\Tests\Mocks\DateHash;

class CacheableTest extends TestCase
{
    /** @test */
    public function cache_key_is_correct()
    {
        $todaysDate = new DateHash();

        $this->assertNotNull($todaysDate->cacheKey());
        $this->assertIsString($todaysDate->cacheKey());
    }

    /** @test */
    public function values_can_be_cached()
    {
        $todaysDate = new DateHash();

        $output = $todaysDate->fetch();

        $this->assertTrue($todaysDate->isCached());
        $this->assertEquals(Cache::get($todaysDate->cacheKey()), $output);
    }

    /** @test */
    public function cache_can_be_invalidated()
    {
        $todaysDate = new DateHash();
        $todaysDate->fetch();

        $this->assertTrue($todaysDate->isCached());

        $todaysDate->invalidateCache();
        $this->assertFalse($todaysDate->isCached());
    }
}
