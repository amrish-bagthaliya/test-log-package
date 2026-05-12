<?php

declare(strict_types=1);

use Illuminate\Console\Events\ScheduledTaskFailed;
use Illuminate\Console\Events\ScheduledTaskFinished;
use Illuminate\Console\Events\ScheduledTaskStarting;
use Illuminate\Console\Scheduling\Event as SchedulingEvent;
use Illuminate\Console\Scheduling\EventMutex;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Oddfellows\OddfellowsTest2LogPackage\Models\SchedulerLog;

uses(RefreshDatabase::class);

beforeEach(function (): void
{
    config([
        'oddfellows-test2-log-package.enabled'           => true,
        'oddfellows-test2-log-package.store_in_database' => true,
        'oddfellows-test2-log-package.log_success'       => true,
        'oddfellows-test2-log-package.log_failure'       => true,
        'oddfellows-test2-log-package.log_started'       => false,
    ]);
});

function makeScheduledTask(string $command, ?string $description = null): SchedulingEvent
{
    return tap(new SchedulingEvent(new class implements EventMutex
    {
        public function create(SchedulingEvent $event): bool
        {
            return true;
        }

        public function exists(SchedulingEvent $event): bool
        {
            return false;
        }

        public function forget(SchedulingEvent $event): void {}
    }, $command), function (SchedulingEvent $task) use ($description): void
    {
        $task->description = $description;
    });
}

it('writes a started log when a scheduler starting event is dispatched', function (): void
{
    config(['oddfellows-test2-log-package.log_started' => true]);

    $task = makeScheduledTask('inspire', 'Inspire command');
    Event::dispatch(new ScheduledTaskStarting($task));

    $log = SchedulerLog::first();

    expect($log)->not()->toBeNull();
    expect($log->status)->toBe('started');
    expect($log->command)->toBe('inspire');
    expect($log->description)->toBeNull();
    expect($log->hostname)->toBeString();
});

it('writes a successful log when a scheduler finished event is dispatched', function (): void
{
    $task = makeScheduledTask('inspire', 'Inspire command');
    Event::dispatch(new ScheduledTaskFinished($task, 0.5));

    $log = SchedulerLog::first();

    expect($log)->not()->toBeNull();
    expect($log->status)->toBe('success');
    expect($log->command)->toBe('inspire');
    expect($log->description)->toBe('Inspire command');
    expect($log->duration)->toBeNull();
    expect($log->hostname)->toBeString();
});

it('writes a failed log when a scheduler failed event is dispatched', function (): void
{
    $task = makeScheduledTask('inspire', 'Inspire command');
    Event::dispatch(new ScheduledTaskFailed($task, new RuntimeException('failed')));

    $log = SchedulerLog::first();

    expect($log)->not()->toBeNull();
    expect($log->status)->toBe('failed');
    expect($log->command)->toBe('inspire');
    expect($log->description)->toBe('Inspire command');
    expect($log->error)->toBe('failed');
    expect($log->exit_code)->toBe(1);
    expect($log->hostname)->toBeString();
});
