<?php

use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetCategories\AssetCategoryResource;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetMovements\AssetMovementResource;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetRepairs\AssetRepairResource;
use JeffersonGoncalves\FilamentErp\Assets\Resources\Assets\AssetResource;
use JeffersonGoncalves\FilamentErp\Assets\Widgets\AssetStatsWidget;

return [

    /*
    |--------------------------------------------------------------------------
    | Navigation Group
    |--------------------------------------------------------------------------
    |
    | The navigation group under which all ERP assets resources are listed in
    | the Filament panel. Override per-plugin with ->navigationGroup('...').
    |
    */

    'navigation_group' => 'ERP — Assets',

    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    |
    | The Filament resource classes registered by the plugin. Each entry can be
    | swapped for a custom resource extending the default one.
    |
    */

    'resources' => [
        'asset_category' => AssetCategoryResource::class,
        'asset' => AssetResource::class,
        'asset_movement' => AssetMovementResource::class,
        'asset_repair' => AssetRepairResource::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Widgets
    |--------------------------------------------------------------------------
    |
    | The Filament widgets registered by the plugin on the panel dashboard.
    |
    */

    'widgets' => [
        'asset_stats' => AssetStatsWidget::class,
    ],

];
