<?php

namespace Sfneal\Caching\Tests\Unit;

use Illuminate\Support\Facades\Cache;
use Sfneal\Caching\Tests\Assets\AutoKeyPoundConverter;
use Sfneal\Caching\Tests\TestCase;

class CacheableTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider cacheablesProvider
     *
     * @param  $cacheable
     */
    public function cache_key_is_correct($cacheable)
    {
        $this->assertNotNull($cacheable->cacheKey());
        $this->assertIsString($cacheable->cacheKey());
    }

    /** @test */
    public function cache_key_is_correct_auto_generate()
    {
        $num = rand(0, 1000);
        $cacheable = new AutoKeyPoundConverter($num);

        $this->assertNotNull($cacheable->cacheKey());
        $this->assertIsString($cacheable->cacheKey());
        $this->assertStringContainsString(
            'auto_sfneal-caching-tests-assets-autokeypoundconverter',
            $cacheable->cacheKey()
        );
        $this->assertEquals(
            'auto_sfneal-caching-tests-assets-autokeypoundconverter:'.$num,
            $cacheable->cacheKey()
        );
    }

    /**
     * @test
     *
     * @dataProvider cacheablesProvider
     *
     * @param  $cacheable
     */
    public function values_can_be_cached($cacheable)
    {
        $output = $cacheable->fetch();

        $this->assertTrue($cacheable->isCached());
        $this->assertEquals(Cache::get($cacheable->cacheKey()), $output);
    }

    /**
     * @test
     *
     * @dataProvider cacheablesProvider
     *
     * @param  $cacheable
     */
    public function values_can_be_retrieved_without_caching($cacheable)
    {
        $output = $cacheable->execute();

        $this->assertFalse($cacheable->isCached());
        $this->assertEquals($cacheable->fetch(), $output);
    }

    /**
     * @test
     *
     * @dataProvider cacheablesProvider
     *
     * @param  $cacheable
     */
    public function cache_can_be_invalidated($cacheable)
    {
        $cacheable->fetch();

        $this->assertTrue($cacheable->isCached());

        $cacheable->invalidateCache();
        $this->assertFalse($cacheable->isCached());
    }
}
