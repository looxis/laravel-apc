<?php

namespace Looxis\Laravel\APC\Tests;

use Looxis\Laravel\APC\APC;
use Looxis\Laravel\APC\APCFacade;
use Looxis\Laravel\APC\APCServiceProvider;
use Orchestra\Testbench\TestCase;

class LaravelAPCTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            APCServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'APC' => APCFacade::class
        ];
    }

    /** @test */
    public function laravel_testing_environment_booted()
    {
        $this->assertTrue(app()->environment('testing'));
    }

    /** @test */
    public function test_apc_constructor()
    {
        $this->assertEquals(APC::class, get_class(app('APC')));
    }
}
