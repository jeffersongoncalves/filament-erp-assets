<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Concerns;

use JeffersonGoncalves\FilamentErp\Core\Concerns\HasErpPluginConfig;

trait HasErpAssetsPluginConfig
{
    use HasErpPluginConfig;

    protected function getConfigKey(): string
    {
        return 'filament-erp-assets';
    }

    protected function getDefaultNavigationGroup(): string
    {
        return 'ERP — Assets';
    }
}
