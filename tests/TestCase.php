<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Fix for Doctrine DBAL enum issue in SQLite
        try {
             $connection = \Illuminate\Support\Facades\DB::connection();
             if ($connection->getDriverName() === 'sqlite') {
                 $connection->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
             }
        } catch (\Throwable $e) {
            // Ignore if it fails, closest effort
        }
    }
}
