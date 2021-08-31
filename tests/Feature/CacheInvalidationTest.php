<?php

namespace Sfneal\Caching\Tests\Feature;

use Sfneal\Caching\Tests\Assets\EuroConverter;
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

        foreach ($conversions as $conversion) {
            $conversion->fetch();
            $this->assertTrue($conversion->isCached());
        }

        $conversions[0]->invalidateCache();

        foreach ($conversions as $conversion) {
            $this->assertFalse($conversion->isCached());
        }
    }
}
