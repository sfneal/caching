<?php

namespace Sfneal\Caching\Tests\Feature;

use Sfneal\Caching\Tests\Assets\DateHash;
use Sfneal\Caching\Tests\Assets\EuroConverter;
use Sfneal\Caching\Tests\TestCase;

class CacheInvalidationTest extends TestCase
{
    /** @test */
    public function date_hash_group_can_be_invalidated()
    {
        $dateHashes = [
            new DateHash(now(), 'Y-m-d'),
            new DateHash(now(), 'm/d/Y'),
            new DateHash(now(), 'm/d/y'),
        ];

        foreach ($dateHashes as $dateHash) {
            $dateHash->fetch();
            $this->assertTrue($dateHash->isCached());
        }

        // todo: should only need to invalidate one
        $dateHashes[0]->invalidateCache();
        $dateHashes[1]->invalidateCache();
        $dateHashes[2]->invalidateCache();

        foreach ($dateHashes as $dateHash) {
            $this->assertFalse($dateHash->isCached());
        }
    }

    /** @test */
    public function euro_converter_can_be_invalidated()
    {
        $euroConversions = [
            new EuroConverter(rand(0, 1000)),
            new EuroConverter(rand(0, 1000)),
            new EuroConverter(rand(0, 1000)),
        ];

        foreach ($euroConversions as $conversion) {
            $this->assertTrue($conversion->isCached());
        }

        // todo: should only need to invalidate one
        $euroConversions[0]->invalidateCache();

        foreach ($euroConversions as $conversion) {
            $this->assertFalse($conversion->isCached());
        }
    }
}
