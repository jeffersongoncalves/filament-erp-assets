<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Resources\AssetMovements\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetMovements\AssetMovementResource;

class EditAssetMovement extends EditRecord
{
    protected static string $resource = AssetMovementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
