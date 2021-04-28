<?php

namespace Sfneal\Caching\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Sfneal\Helpers\Redis\Providers\RedisHelpersServiceProvider;

class TestCase extends OrchestraTestCase
{
    /**
     * Register package service providers.
     *
     * @param Application $app
     * @return array|string
     */
    protected function getPackageProviders($app)
    {
        return RedisHelpersServiceProvider::class;
    }
}
