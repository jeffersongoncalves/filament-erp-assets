<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Resources\AssetRepairs;

use Filament\Forms\Form;
use Filament\Resources\Resource;
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
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

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

    public static function form(Form $form): Form
    {
        return AssetRepairForm::configure($form);
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
