<?php

declare(strict_types=1);

namespace Oddfellows\OddfellowsTest2LogPackage\Listeners;

use Illuminate\Console\Events\ScheduledTaskFinished;
use Oddfellows\OddfellowsTest2LogPackage\Models\SchedulerLog;

class LogSchedulerSuccess
{
    /**
     * Handle the event.
     */
    public function handle(ScheduledTaskFinished $event): void
    {
        if (! config('oddfellows-test2-log-package.enabled'))
        {
            return;
        }

        if (! config('oddfellows-test2-log-package.log_success'))
        {
            return;
        }

        if (! config('oddfellows-test2-log-package.store_in_database'))
        {
            return;
        }

        SchedulerLog::create([
            'command'     => $event->task->command,
            'status'      => 'success',
            'description' => $event->task->description,
            'duration'    => null,
            'hostname'    => gethostname() ?: 'unknown',
        ]);
    }
}
