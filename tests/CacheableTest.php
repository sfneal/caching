<?php

namespace Sfneal\Caching\Tests;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Sfneal\Caching\Tests\Mocks\DateHash;

class CacheableTest extends TestCase
{
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
