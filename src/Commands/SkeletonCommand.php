<?php

declare(strict_types=1);

namespace VendorName\PackageNamespace\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Throwable;

/** @internal */
#[AsCommand(
    'skeleton',
    'My command'
)]
class SkeletonCommand extends Command
{
    public function handle(): int
    {
        try
        {
            return self::SUCCESS;
        }
        catch (Throwable $throwable)
        {
            report($throwable);

            return self::FAILURE;
        }
    }
}
