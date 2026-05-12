<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Oddfellows\OddfellowsTest2LogPackage\Models\SchedulerLog;

uses(RefreshDatabase::class);

describe('SchedulerLog Model', function (): void
{
    it('can create a scheduler log', function (): void
    {
        $log = SchedulerLog::create([
            'command'     => 'inspire',
            'status'      => 'success',
            'description' => 'Inspire command',
            'duration'    => 1234.5,
            'hostname'    => 'localhost',
        ]);

        expect($log)->toBeInstanceOf(SchedulerLog::class);
        expect($log->command)->toBe('inspire');
        expect($log->status)->toBe('success');
        expect(SchedulerLog::count())->toBe(1);
        expect($log->created_at)->not()->toBeNull();
    });

    it('casts duration and exit_code correctly', function (): void
    {
        $log = SchedulerLog::create([
            'command'     => 'inspire',
            'status'      => 'success',
            'description' => 'Inspire command',
            'duration'    => 1234.5,
            'exit_code'   => 0,
            'hostname'    => 'localhost',
        ]);

        expect($log->duration)->toBeFloat();
        expect($log->exit_code)->toBeInt();
    });

    it('filters successful logs using the successful scope', function (): void
    {
        SchedulerLog::create(['command' => 'task:one', 'status' => 'success', 'hostname' => 'localhost']);
        SchedulerLog::create(['command' => 'task:two', 'status' => 'failed', 'hostname' => 'localhost']);
        SchedulerLog::create(['command' => 'task:three', 'status' => 'success', 'hostname' => 'localhost']);

        $successful = SchedulerLog::successful()->orderBy('command')->pluck('command')->all();

        expect($successful)->toEqual(['task:one', 'task:three']);
    });

    it('filters failed logs using the failed scope', function (): void
    {
        SchedulerLog::create(['command' => 'task:one', 'status' => 'success', 'hostname' => 'localhost']);
        SchedulerLog::create(['command' => 'task:two', 'status' => 'failed', 'hostname' => 'localhost']);
        SchedulerLog::create(['command' => 'task:three', 'status' => 'success', 'hostname' => 'localhost']);

        $failed = SchedulerLog::failed()->pluck('command')->all();

        expect($failed)->toEqual(['task:two']);
    });
});
