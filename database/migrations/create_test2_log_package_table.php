<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scheduler_logs', function (Blueprint $table): void
        {
            $table->id();
            $table->string('command')->index();
            $table->enum('status', ['started', 'success', 'failed'])->default('started')->index();
            $table->text('description')->nullable();
            $table->text('error')->nullable();
            $table->float('duration')->nullable()->comment('Duration in milliseconds');
            $table->integer('exit_code')->nullable();
            $table->string('hostname')->nullable();
            $table->timestamps();
            $table->index('created_at');
        });
    }
};
