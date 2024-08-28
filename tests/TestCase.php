<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    protected static bool $setUpHasRunOnce = false;

    /**
     *
     */
    public function setUp(): void
    {
        parent::setUp();
        if (!static::$setUpHasRunOnce) {
            Artisan::call('migrate:fresh');
            static::$setUpHasRunOnce = true;
        }
    }
}
