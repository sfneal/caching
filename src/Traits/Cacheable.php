<?php

namespace Sfneal\Caching\Traits;

use Illuminate\Database\Eloquent\Collection;
use Sfneal\Helpers\Redis\RedisCache;

trait Cacheable
{
    // todo: add isCached() among other methods
    // todo: add method for overwriting cache
    // todo: add get ttl method for seeing how long before expiration

    /**
     * @var int Time to live
     */
    public $ttl = null;

    /**
     * Execute the Query.
     *
     * @return Collection|int|mixed
     */
    abstract public function execute();

    /**
     * Retrieve the Query cache key.
     *
     * @return string
     */
    abstract public function cacheKey(): string;

    /**
     * Fetch cached Query results.
     *
     *  - use cacheKey() method to retrieve correct key to use for storing in cache
     *  - use base class's execute() method for retrieving query results
     *
     * @param int|null $ttl
     * @return Collection|mixed
     */
    public function fetch(int $ttl = null)
    {
        return RedisCache::remember($this->cacheKey(), $this->getTTL($ttl), function () {
            return $this->execute();
        });
    }

    /**
     * Retrieve the time to live for the cached values
     *  - 1. passed $ttl parameter
     *  - 2. initialized $this->ttl property
     *  - 3. application default cache ttl.
     *
     * @param int|null $ttl
     * @return int|mixed
     */
    private function getTTL(int $ttl = null)
    {
        return $ttl ?? $this->ttl ?? env('REDIS_KEY_EXPIRATION');
    }

    /**
     * Invalidate the Query Cache for this Query.
     */
    public function invalidateCache()
    {
        // todo: refactor to protected method
        // Remove # ID's from cache key
        RedisCache::delete(collect(explode('#', $this->cacheKey(), 1))->first());

        return $this;
    }
}
