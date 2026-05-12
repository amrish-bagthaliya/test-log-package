<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Scheduler Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Configure how the scheduler logging package should behave.
    |
    */

    'enabled' => env('SCHEDULER_LOG_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Store Logs in Database
    |--------------------------------------------------------------------------
    |
    | Whether to store scheduler logs in the database
    |
    */
    'store_in_database' => env('SCHEDULER_LOG_DATABASE', true),

    /*
    |--------------------------------------------------------------------------
    | Log Successful Tasks
    |--------------------------------------------------------------------------
    |
    | Whether to log successful task executions
    |
    */
    'log_success' => env('SCHEDULER_LOG_SUCCESS', true),

    /*
    |--------------------------------------------------------------------------
    | Log Failed Tasks
    |--------------------------------------------------------------------------
    |
    | Whether to log failed task executions
    |
    */
    'log_failure' => env('SCHEDULER_LOG_FAILURE', true),

    /*
    |--------------------------------------------------------------------------
    | Log Started Tasks
    |--------------------------------------------------------------------------
    |
    | Whether to log when tasks start
    |
    */
    'log_started' => env('SCHEDULER_LOG_STARTED', false),
];
