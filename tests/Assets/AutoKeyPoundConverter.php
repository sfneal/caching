<?php

namespace Sfneal\Caching\Tests\Assets;

use Sfneal\Caching\Traits\Cacheable;
use Sfneal\Caching\Traits\HasAutoCacheKey;
use Sfneal\Currency\Currency;

class AutoKeyPoundConverter
{
    use Cacheable;
    use HasAutoCacheKey;

    /**
     * @var int
     */
    private $amount;

    /**
     * EuroConverter constructor.
     *
     * @param  int  $amount
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
}
