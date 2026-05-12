<?php

declare(strict_types=1);

namespace Oddfellows\OddfellowsTest2LogPackage;

use Illuminate\Console\Events\ScheduledTaskFailed;
use Illuminate\Console\Events\ScheduledTaskFinished;

use Illuminate\Console\Events\ScheduledTaskStarting;
use Illuminate\Support\Facades\Event;
use Oddfellows\OddfellowsTest2LogPackage\Listeners\LogSchedulerFailure;
use Oddfellows\OddfellowsTest2LogPackage\Listeners\LogSchedulerStarting;
use Oddfellows\OddfellowsTest2LogPackage\Listeners\LogSchedulerSuccess;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class Test2LogPackageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('oddfellows-test2-log-package')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_test2_log_package_table');
    }

    public function bootingPackage(): void
    {
        $this->registerEventListeners();
    }

    private function registerEventListeners(): void
    {
        Event::listen(ScheduledTaskFinished::class, LogSchedulerSuccess::class);
        Event::listen(ScheduledTaskFailed::class, LogSchedulerFailure::class);
        Event::listen(ScheduledTaskStarting::class, LogSchedulerStarting::class);
    }
}
