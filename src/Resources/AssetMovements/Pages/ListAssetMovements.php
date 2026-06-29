<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Resources\AssetMovements\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetMovements\AssetMovementResource;

class ListAssetMovements extends ListRecords
{
    protected static string $resource = AssetMovementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
