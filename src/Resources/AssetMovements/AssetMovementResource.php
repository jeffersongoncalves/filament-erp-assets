<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Resources\AssetMovements;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Assets\Support\ModelResolver;
use JeffersonGoncalves\FilamentErp\Assets\FilamentErpAssetsPlugin;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetMovements\Pages\CreateAssetMovement;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetMovements\Pages\EditAssetMovement;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetMovements\Pages\ListAssetMovements;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetMovements\Schemas\AssetMovementForm;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetMovements\Tables\AssetMovementsTable;

class AssetMovementResource extends Resource
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'naming_series';

    public static function getModel(): string
    {
        return ModelResolver::assetMovement();
    }

    public static function getNavigationGroup(): ?string
    {
        try {
            return FilamentErpAssetsPlugin::get()->getNavigationGroup();
        } catch (\Throwable) {
            return config('filament-erp-assets.navigation_group', 'ERP — Assets');
        }
    }

    public static function form(Schema $schema): Schema
    {
        return AssetMovementForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssetMovementsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssetMovements::route('/'),
            'create' => CreateAssetMovement::route('/create'),
            'edit' => EditAssetMovement::route('/{record}/edit'),
        ];
    }
}
