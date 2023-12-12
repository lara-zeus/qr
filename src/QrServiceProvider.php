<?php

namespace LaraZeus\Qr;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class QrServiceProvider extends PackageServiceProvider
{
    public static string $name = 'zeus-qr';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name);
    }
}
