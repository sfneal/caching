<?php

namespace Sfneal\Caching\Tests\Feature;

use Sfneal\Caching\Tests\Assets\Converter;
use Sfneal\Caching\Tests\Assets\DollarConverter;
use Sfneal\Caching\Tests\Assets\EuroConverter;
use Sfneal\Caching\Tests\Assets\PoundConverter;
use Sfneal\Caching\Tests\TestCase;

class CacheInvalidationTest extends TestCase
{
    /** @test */
    public function euro_converter_can_be_invalidated()
    {
        $conversions = [
            new EuroConverter(rand(0, 1000)),
            new EuroConverter(rand(0, 1000)),
            new EuroConverter(rand(0, 1000)),
        ];

        $conversions[0]->invalidateCache();

        foreach ($conversions as $conversion) {
            $this->assertFalse($conversion->isCached());
            $conversion->fetch();
            $this->assertTrue($conversion->isCached());
        }

        $invalidations = $conversions[0]->invalidateCache();

        $this->assertCacheInvalidated($conversions, $invalidations);
    }

    /** @test */
    public function pound_converter_can_be_invalidated()
    {
        $conversions = [
            new PoundConverter(rand(0, 1000)),
            new PoundConverter(rand(0, 1000)),
            new PoundConverter(rand(0, 1000)),
        ];

        $conversions[0]->invalidateCache();

        foreach ($conversions as $conversion) {
            $this->assertFalse($conversion->isCached());
            $conversion->fetch();
            $this->assertTrue($conversion->isCached());
        }

        $invalidations = $conversions[0]->invalidateCache();

        $this->assertCacheInvalidated($conversions, $invalidations);
    }

    /** @test */
    public function dollar_converter_can_be_invalidated()
    {
        $conversions = [
            new DollarConverter(rand(0, 1000)),
            new DollarConverter(rand(0, 1000)),
            new DollarConverter(rand(0, 1000)),
        ];

        $conversions[0]->invalidateCache();

        foreach ($conversions as $conversion) {
            $this->assertFalse($conversion->isCached());
            $conversion->fetch();
            $this->assertTrue($conversion->isCached());
        }

        $invalidations = $conversions[0]->invalidateCache();

        $this->assertCacheInvalidated($conversions, $invalidations);
    }

    /** @test */
    public function all_conversions_can_be_invalidated()
    {
        $conversions = [
            new EuroConverter(rand(0, 1000)),
            new EuroConverter(rand(0, 1000)),
            new EuroConverter(rand(0, 1000)),
            new PoundConverter(rand(0, 1000)),
            new PoundConverter(rand(0, 1000)),
            new PoundConverter(rand(0, 1000)),
            new DollarConverter(rand(0, 1000)),
            new DollarConverter(rand(0, 1000)),
            new DollarConverter(rand(0, 1000)),
        ];

        foreach ($conversions as $conversion) {
            $this->assertFalse($conversion->isCached());
            $conversion->fetch();
            $this->assertTrue($conversion->isCached());
        }

        $invalidations = (new Converter)->invalidateCache();
        unset($invalidations['currency-conversions']);

        $this->assertCacheInvalidated($conversions, $invalidations);
    }

    /**
     * Execute assertions to confirm the cache has been invalidated.
     *
     * @param  array  $conversions
     * @param  $invalidations
     */
    public function assertCacheInvalidated(array $conversions, $invalidations): void
    {
        $this->assertIsArray($invalidations);
        $this->assertGreaterThanOrEqual(count($conversions), $invalidations);

        $this->assertEquals(
            array_values(
                collect(array_keys($invalidations))
                    ->sort()
                    ->toArray()
            ),
            array_values(
                collect($conversions)
                    ->map(function (Converter $converter) {
                        return $converter->cacheKey();
                    })
                    ->sort()
                    ->toArray()
            )
        );
        $this->assertEquals(array_fill(0, count($conversions), 1), array_values($invalidations));

        foreach ($conversions as $conversion) {
            $this->assertFalse($conversion->isCached());
        }
    }
}
