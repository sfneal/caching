<?php

namespace Sfneal\Caching\Traits;

trait HasAutoCacheKey
{
    use IsCacheable;

    /**
     * Retrieve the Query cache key.
     *
     * @return string
     */
    public function cacheKey(): string
    {
        $reflection = (new \ReflectionClass($this));

        $key = 'auto_'.strtolower(str_replace('\\', '-', $reflection->getName()));

        if (count($reflection->getProperties())) {
            foreach ($reflection->getProperties() as $property) {
                if ($property->getName() != 'ttl') {
                    $key .= ':'.$this->{$property->getName()};
                }
            }
        }

        return $key;
    }
}
