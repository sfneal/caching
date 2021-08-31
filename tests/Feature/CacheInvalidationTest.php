<?php

namespace Sfneal\Caching\Tests\Feature;

use Sfneal\Caching\Tests\Assets\EuroConverter;
use Sfneal\Caching\Tests\TestCase;

class CacheInvalidationTest extends TestCase
{
    /** @test */
    public function euro_converter_can_be_invalidated()
    {
        $euroConversions = [
            new EuroConverter(rand(0, 1000)),
            new EuroConverter(rand(0, 1000)),
            new EuroConverter(rand(0, 1000)),
        ];

        foreach ($euroConversions as $conversion) {
            $conversion->fetch();
            $this->assertTrue($conversion->isCached());
        }

        // todo: should only need to invalidate one
        $euroConversions[0]->invalidateCache();

        foreach ($euroConversions as $conversion) {
            $this->assertFalse($conversion->isCached());
        }
    }
}
