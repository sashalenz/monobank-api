<?php

namespace Sashalenz\MonobankApi\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Sashalenz\MonobankApi\MonobankApiServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            MonobankApiServiceProvider::class,
        ];
    }
}
