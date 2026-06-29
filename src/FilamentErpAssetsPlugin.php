<?php

namespace JeffersonGoncalves\FilamentErp\Assets;

use Filament\Contracts\Plugin;
use Filament\Panel;
use JeffersonGoncalves\FilamentErp\Assets\Concerns\HasErpAssetsPluginConfig;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetCategories\AssetCategoryResource;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetMovements\AssetMovementResource;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetRepairs\AssetRepairResource;
use JeffersonGoncalves\FilamentErp\Assets\Resources\Assets\AssetResource;

class FilamentErpAssetsPlugin implements Plugin
{
    use HasErpAssetsPluginConfig;

    public function getId(): string
    {
        return 'filament-erp-assets';
    }

    public function register(Panel $panel): void
    {
        $panel->resources($this->resolveResources([
            'asset_category' => AssetCategoryResource::class,
            'asset' => AssetResource::class,
            'asset_movement' => AssetMovementResource::class,
            'asset_repair' => AssetRepairResource::class,
        ]));

        $panel->widgets($this->resolveWidgets());
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
