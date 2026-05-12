<?php

declare(strict_types=1);

use Illuminate\Console\Events\ScheduledTaskFailed;
use Illuminate\Console\Events\ScheduledTaskFinished;
use Illuminate\Console\Events\ScheduledTaskStarting;
use Illuminate\Support\Facades\Event;
use Oddfellows\OddfellowsTest2LogPackage\Test2LogPackageServiceProvider;

it('registers the package service provider', function (): void
{
    $provider = $this->app->getProvider(Test2LogPackageServiceProvider::class);

    expect($provider)->toBeInstanceOf(Test2LogPackageServiceProvider::class);
});

it('loads the default package config values', function (): void
{
    expect(config('oddfellows-test2-log-package.enabled'))->toBeTrue();
    expect(config('oddfellows-test2-log-package.store_in_database'))->toBeTrue();
    expect(config('oddfellows-test2-log-package.log_success'))->toBeTrue();
    expect(config('oddfellows-test2-log-package.log_failure'))->toBeTrue();
    expect(config('oddfellows-test2-log-package.log_started'))->toBeFalse();
});

it('registers scheduler event listeners', function (): void
{
    expect(Event::hasListeners(ScheduledTaskFinished::class))->toBeTrue();
    expect(Event::hasListeners(ScheduledTaskFailed::class))->toBeTrue();
    expect(Event::hasListeners(ScheduledTaskStarting::class))->toBeTrue();
});
