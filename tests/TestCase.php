<?php

declare(strict_types=1);

namespace Oddfellows\OddfellowsTest2LogPackage\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Oddfellows\OddfellowsTest2LogPackage\Test2LogPackageServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Oddfellows\\OddfellowsTest2LogPackage\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
        config()->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        foreach (\Illuminate\Support\Facades\File::allFiles(__DIR__ . '/../database/migrations') as $migration)
        {
            (include $migration->getRealPath())->up();
        }
    }

    protected function getPackageProviders($app)
    {
        return [
            Test2LogPackageServiceProvider::class,
        ];
    }
}
