<?php

namespace Sfneal\Caching\Tests\Unit;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Sfneal\Caching\Tests\Assets\DateHash;
use Sfneal\Caching\Tests\TestCase;

class CacheableTest extends TestCase
{
    /**
     * @test
     * @dataProvider dateHashParamsProvider
     * @param Carbon $datetime
     * @param string $format
     */
    public function cache_key_is_correct(Carbon $datetime, string $format)
    {
        $dateHash = new DateHash($datetime, $format);

        $this->assertNotNull($dateHash->cacheKey());
        $this->assertIsString($dateHash->cacheKey());
    }

    /**
     * @test
     * @dataProvider dateHashParamsProvider
     * @param Carbon $datetime
     * @param string $format
     */
    public function values_can_be_cached(Carbon $datetime, string $format)
    {
        $dateHash = new DateHash($datetime, $format);

        $output = $dateHash->fetch();

        $this->assertTrue($dateHash->isCached());
        $this->assertEquals(Cache::get($dateHash->cacheKey()), $output);
    }

    /**
     * @test
     * @dataProvider dateHashParamsProvider
     * @param Carbon $datetime
     * @param string $format
     */
    public function cache_can_be_invalidated(Carbon $datetime, string $format)
    {
        $dateHash = new DateHash($datetime, $format);
        $dateHash->fetch();

        $this->assertTrue($dateHash->isCached());

        $dateHash->invalidateCache();
        $this->assertFalse($dateHash->isCached());
    }
}
