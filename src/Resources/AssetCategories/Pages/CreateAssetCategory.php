<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Resources\AssetCategories\Pages;

use Filament\Resources\Pages\CreateRecord;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetCategories\AssetCategoryResource;

class CreateAssetCategory extends CreateRecord
{
    protected static string $resource = AssetCategoryResource::class;
}
