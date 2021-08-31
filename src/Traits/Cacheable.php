<?php

namespace Sfneal\Caching\Traits;

use Illuminate\Database\Eloquent\Collection;
use Sfneal\Helpers\Redis\RedisCache;

trait Cacheable
{
    use IsCacheable;

    // todo: add method for overwriting cache
    // todo: add get ttl method for seeing how long before expiration
    // todo: remove use of `RedisHelpers`
    // todo: create new trait that replaces execute with `get()`?

    /**
     * @var int Time to live
     */
    public $ttl = null;

    /**
     * Retrieve the cached data.
     *
     * @return Collection|int|mixed
     */
    abstract public function execute();

    /**
     * Fetch cached Query results.
     *
     *  - use cacheKey() method to retrieve correct key to use for storing in cache
     *  - use base class's execute() method for retrieving query results
     *
     * @param int|null $ttl
     * @return mixed
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
     * @return int
     */
    private function getTTL(int $ttl = null): int
    {
        return intval($ttl ?? $this->ttl ?? config('redis-helpers.ttl'));
    }

    /**
     * Invalidate the Query Cache for this Query.
     *
     * @return self
     */
    public function invalidateCache(): self
    {
        // todo: refactor to protected method?
        RedisCache::delete($this->cacheKeyPrefix());

        return $this;
    }

    /**
     * Retrieve the cache key prefix by removing the trailing 'id' portion of the key.
     *
     * @return string
     */
    public function cacheKeyPrefix(): string
    {
        // Explode the cache key into an array split by a colon
        $pieces = explode(':', $this->cacheKey());

        // Isolate the 'ID' portion of the cache (last segment)
        $id = array_reverse($pieces)[0];

        // Remove the ID from the cache key to retrieve the prefix
        return str_replace($id, '', $this->cacheKey());
    }
}
