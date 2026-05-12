<?php

declare(strict_types=1);

use Oddfellows\OddfellowsTest2LogPackage\Models\SchedulerLog;

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
    });

    it('casts attributes correctly', function (): void
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

    it('can query successful logs', function (): void
    {
        SchedulerLog::create(['command' => 'test1', 'status' => 'success', 'hostname' => 'localhost']);
        SchedulerLog::create(['command' => 'test2', 'status' => 'failed', 'hostname' => 'localhost']);
        SchedulerLog::create(['command' => 'test3', 'status' => 'success', 'hostname' => 'localhost']);

        $successful = SchedulerLog::successful()->get();

        expect($successful)->toHaveCount(2);
    });

    it('can query failed logs', function (): void
    {
        SchedulerLog::create(['command' => 'test1', 'status' => 'success', 'hostname' => 'localhost']);
        SchedulerLog::create(['command' => 'test2', 'status' => 'failed', 'hostname' => 'localhost']);
        SchedulerLog::create(['command' => 'test3', 'status' => 'success', 'hostname' => 'localhost']);

        $failed = SchedulerLog::failed()->get();

        expect($failed)->toHaveCount(1);
    });
});
