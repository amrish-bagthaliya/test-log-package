<?php

declare(strict_types=1);

namespace Oddfellows\OddfellowsTest2LogPackage\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SchedulerLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scheduler_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'command',
        'status',
        'description',
        'error',
        'duration',
        'exit_code',
        'hostname',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'started_at'  => 'datetime',
        'finished_at' => 'datetime',
        'duration'    => 'float',
        'exit_code'   => 'int',
    ];

    /**
     * Get successful logs.
     */
    public function scopeSuccessful(Builder $query): Builder
    {
        return $query->where('status', 'success');
    }

    /**
     * Get failed logs.
     */
    public function scopeFailed(Builder $query): Builder
    {
        return $query->where('status', 'failed');
    }
}
