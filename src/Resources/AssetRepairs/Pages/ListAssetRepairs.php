<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Resources\AssetRepairs\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetRepairs\AssetRepairResource;

class ListAssetRepairs extends ListRecords
{
    protected static string $resource = AssetRepairResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
