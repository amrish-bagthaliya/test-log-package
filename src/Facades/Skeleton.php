<?php

declare(strict_types=1);

namespace VendorName\PackageNamespace\Facades;

use Illuminate\Support\Facades\Facade;

/** @see \VendorName\PackageNamespace\Skeleton */
class Skeleton extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \VendorName\PackageNamespace\Skeleton::class;
    }
}
