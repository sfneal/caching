<?php

namespace Sfneal\Caching\Tests\Assets;

use Sfneal\Currency\Currency;

class PoundConverter extends Converter
{
    /**
     * @var int
     */
    private $amount;

    /**
     * EuroConverter constructor.
     *
     * @param int $amount
     */
    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    /**
     * Execute the Query.
     *
     * @return string
     */
    public function execute(): string
    {
        return Currency::pounds($this->amount);
    }

    /**
     * Retrieve the Query cache key.
     *
     * @return string
     */
    public function cacheKey(): string
    {
        return parent::cacheKey().":pounds:{$this->amount}";
    }
}
