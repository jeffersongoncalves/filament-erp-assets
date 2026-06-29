<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Resources\AssetRepairs;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Assets\Support\ModelResolver;
use JeffersonGoncalves\FilamentErp\Assets\FilamentErpAssetsPlugin;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetRepairs\Pages\CreateAssetRepair;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetRepairs\Pages\EditAssetRepair;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetRepairs\Pages\ListAssetRepairs;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetRepairs\Schemas\AssetRepairForm;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetRepairs\Tables\AssetRepairsTable;

class AssetRepairResource extends Resource
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static ?int $navigationSort = 30;

    protected static ?string $recordTitleAttribute = 'naming_series';

    public static function getModel(): string
    {
        return ModelResolver::assetRepair();
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
        return AssetRepairForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssetRepairsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssetRepairs::route('/'),
            'create' => CreateAssetRepair::route('/create'),
            'edit' => EditAssetRepair::route('/{record}/edit'),
        ];
    }
}
