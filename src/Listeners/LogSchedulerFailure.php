<?php

declare(strict_types=1);

namespace Oddfellows\OddfellowsTest2LogPackage\Listeners;

use Illuminate\Console\Events\ScheduledTaskFailed;
use Oddfellows\OddfellowsTest2LogPackage\Models\SchedulerLog;

class LogSchedulerFailure
{
    /**
     * Handle the event.
     */
    public function handle(ScheduledTaskFailed $event): void
    {
        if (! config('oddfellows-test2-log-package.enabled'))
        {
            return;
        }

        if (! config('oddfellows-test2-log-package.log_failure'))
        {
            return;
        }

        if (! config('oddfellows-test2-log-package.store_in_database'))
        {
            return;
        }

        SchedulerLog::create([
            'command'     => $event->task->command,
            'status'      => 'failed',
            'description' => $event->task->description,
            'duration'    => null,
            'error'       => $event->exception->getMessage(),
            'exit_code'   => 1,
            'hostname'    => gethostname() ?: 'unknown',
        ]);
    }
}
