<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $apiToken;

    protected function setUp(): void
    {
        parent::setUp();
        DatabaseTestHelper::resetDatabase();
    }
}
