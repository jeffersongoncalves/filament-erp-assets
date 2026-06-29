<?php

namespace JeffersonGoncalves\FilamentErp\Assets;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentErpAssetsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-erp-assets';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasTranslations();
    }
}
