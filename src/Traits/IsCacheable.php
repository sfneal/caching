<?php


namespace Sfneal\Caching\Traits;


use Sfneal\Helpers\Redis\RedisCache;

trait IsCacheable
{
    /**
     * Retrieve the Query cache key.
     *
     * @return string
     */
    abstract public function cacheKey(): string;

    /**
     * Determine if the query is currently cached.
     *
     * @return bool
     */
    public function isCached(): bool
    {
        return RedisCache::exists($this->cacheKey());
    }
}
