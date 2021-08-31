<?php

namespace Sfneal\Caching\Tests\Assets;

use Sfneal\Caching\Traits\Cacheable;

class Converter
{
    use Cacheable;

    /**
     * Execute the Query.
     *
     * @return void
     */
    public function execute()
    {
        //
    }

    /**
     * Retrieve the Query cache key.
     *
     * @return string
     */
    public function cacheKey(): string
    {
        return 'currency-conversions';
    }
}
