<?php

namespace Sfneal\Caching\Tests\Mocks;

use Illuminate\Database\Eloquent\Collection;
use Sfneal\Caching\Traits\Cacheable;

class TodaysDateHash
{
    use Cacheable;

    /**
     * @var string
     */
    private $format;

    /**
     * TodaysDateHash constructor.
     *
     * @param string $format
     */
    public function __construct(string $format = 'Y-m-d')
    {
        $this->format = $format;
    }

    /**
     * Execute the Action.
     *
     * @return Collection|int|mixed
     */
    public function execute()
    {
        return md5(date($this->format));
    }

    /**
     * Retrieve the cache key.
     *
     * @return string
     */
    public function cacheKey(): string
    {
        return "todays-date:{$this->format}";
    }
}
