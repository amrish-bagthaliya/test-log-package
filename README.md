# Oddfellows Test2 Log Package

[![run-tests](hhttps://github.com/amrish-bagthaliya/test-log-package/actions/workflows/run-tests.yml/badge.svg)](https://github.com/amrish-bagthaliya/test-log-package/actions/workflows/run-tests.yml)
[![lint-test](https://github.com/amrish-bagthaliya/test-log-package/actions/workflows/lint-test.yml/badge.svg)](https://github.com/amrish-bagthaliya/test-log-package/actions/workflows/lint-test.yml)
[![PHPStan](https://github.com/amrish-bagthaliya/test-log-package/actions/workflows/phpstan.yml/badge.svg)](https://github.com/amrish-bagthaliya/test-log-package/actions/workflows/phpstan.yml)

A Laravel package that automatically logs scheduler task executions (starting, success, and failure events) to a database table. This helps monitor and debug scheduled tasks in your Laravel applications.

## Installation

You can install the package via composer:

```bash
composer require manchester-unity/oddfellows-test2-log-package
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="oddfellows-test2-log-package-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="oddfellows-test2-log-package-config"
```

This is the contents of the published config file:

```php
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
```

## Usage

The package automatically starts logging scheduler events once installed and configured. No additional code is required in your application.

### Querying Logs

You can query the scheduler logs using the `SchedulerLog` model:

```php
use Oddfellows\OddfellowsTest2LogPackage\Models\SchedulerLog;

// Get all successful logs
$successfulLogs = SchedulerLog::successful()->get();

// Get all failed logs
$failedLogs = SchedulerLog::failed()->get();

// Get logs for a specific command
$logs = SchedulerLog::where('command', 'inspire')->get();
```

### Configuration

Configure the package behavior using environment variables:

```env
SCHEDULER_LOG_ENABLED=true
SCHEDULER_LOG_DATABASE=true
SCHEDULER_LOG_SUCCESS=true
SCHEDULER_LOG_FAILURE=true
SCHEDULER_LOG_STARTED=false
```

## Features

- **Automatic Logging**: Logs are created automatically when scheduler events occur
- **Configurable**: Enable/disable different types of logging via config
- **Database Storage**: Stores logs in a dedicated table with proper indexing
- **Model Scopes**: Convenient query scopes for filtering logs
- **Event-Driven**: Uses Laravel's event system for reliable logging

## Database Schema

The package creates a `scheduler_logs` table with the following columns:

- `id` - Primary key
- `command` - The scheduled command
- `status` - Status: 'started', 'success', or 'failed'
- `description` - Optional description
- `error` - Error message (for failed tasks)
- `duration` - Execution time in milliseconds
- `exit_code` - Process exit code
- `hostname` - Server hostname
- `created_at` - Creation timestamp
- `updated_at` - Update timestamp

## Requirements

- PHP ^8.4
- Laravel framework
- Database connection (MySQL, PostgreSQL, SQLite, etc.)

## License

This package is proprietary software.
echo $test2LogPackage->echoPhrase('Hello, Oddfellows!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.


## Versioning

The package follows [Semantic Versioning 2.0.0](https://semver.org). Pin a major version in `composer.json` (`"manchester-unity/oddfellows-test2-log-package": "^1.0"`) to receive bug fixes and minor features without breaking changes.

## License

Copyright (c) The Oddfellows. All rights reserved. Please see [License File](LICENSE.md) for more information.
