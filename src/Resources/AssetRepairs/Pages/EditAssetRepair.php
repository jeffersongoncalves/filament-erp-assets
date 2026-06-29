<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Resources\AssetRepairs\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetRepairs\AssetRepairResource;

class EditAssetRepair extends EditRecord
{
    protected static string $resource = AssetRepairResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
