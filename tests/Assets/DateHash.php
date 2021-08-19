<?php

namespace Sfneal\Caching\Tests\Assets;

use Sfneal\Caching\Traits\Cacheable;

class DateHash
{
    use Cacheable;

    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $format;

    /**
     * TodaysDateHash constructor.
     *
     * @param string|null $datetime
     * @param string $format
     */
    public function __construct(string $datetime = null, string $format = 'Y-m-d')
    {
        $this->format = $format;
        $this->date = date($this->format, strtotime($datetime ?? now()));
    }

    /**
     * Execute the Action.
     *
     * @return string
     */
    public function execute(): string
    {
        return md5($this->date);
    }

    /**
     * Retrieve the cache key.
     *
     * @return string
     */
    public function cacheKey(): string
    {
        return "date-hash:{$this->date}:{$this->format}";
    }
}
