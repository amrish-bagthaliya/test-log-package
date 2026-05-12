<?php

declare(strict_types=1);

namespace Oddfellows\OddfellowsTest2LogPackage\Facades;

use Illuminate\Support\Facades\Facade;

/** @see \Oddfellows\OddfellowsTest2LogPackage\Test2LogPackage */
class Test2LogPackage extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Oddfellows\OddfellowsTest2LogPackage\Test2LogPackage::class;
    }
}
