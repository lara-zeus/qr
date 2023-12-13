<?php

namespace LaraZeus\Qr;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class QrServiceProvider extends PackageServiceProvider
{
    public static string $name = 'zeus-qr';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews();
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            AlpineComponent::make('qr', __DIR__ . '/../resources/dist/qr.js'),
        ], 'lara-zeus/qr');
    }
}
