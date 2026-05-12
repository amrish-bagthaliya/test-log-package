<?php

declare(strict_types=1);

namespace Oddfellows\OddfellowsTest2LogPackage\Listeners;

use Illuminate\Console\Events\ScheduledTaskStarting;
use Oddfellows\OddfellowsTest2LogPackage\Models\SchedulerLog;

class LogSchedulerStarting
{
    /**
     * Handle the event.
     */
    public function handle(ScheduledTaskStarting $event): void
    {
        if (! config('oddfellows-test2-log-package.enabled'))
        {
            return;
        }

        if (! config('oddfellows-test2-log-package.log_started'))
        {
            return;
        }

        if (! config('oddfellows-test2-log-package.store_in_database'))
        {
            return;
        }

        SchedulerLog::create([
            'command'  => $event->task->command,
            'status'   => 'started',
            'hostname' => gethostname() ?: 'unknown',
        ]);
    }
}
