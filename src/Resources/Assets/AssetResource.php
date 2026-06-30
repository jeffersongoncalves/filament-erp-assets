<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Resources\Assets;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Assets\Support\ModelResolver;
use JeffersonGoncalves\FilamentErp\Assets\FilamentErpAssetsPlugin;
use JeffersonGoncalves\FilamentErp\Assets\Resources\Assets\Pages\CreateAsset;
use JeffersonGoncalves\FilamentErp\Assets\Resources\Assets\Pages\EditAsset;
use JeffersonGoncalves\FilamentErp\Assets\Resources\Assets\Pages\ListAssets;
use JeffersonGoncalves\FilamentErp\Assets\Resources\Assets\RelationManagers\DepreciationScheduleRelationManager;
use JeffersonGoncalves\FilamentErp\Assets\Resources\Assets\Schemas\AssetForm;
use JeffersonGoncalves\FilamentErp\Assets\Resources\Assets\Tables\AssetsTable;

class AssetResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'asset_name';

    public static function getModel(): string
    {
        return ModelResolver::asset();
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
        return AssetForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return AssetsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            DepreciationScheduleRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssets::route('/'),
            'create' => CreateAsset::route('/create'),
            'edit' => EditAsset::route('/{record}/edit'),
        ];
    }
}
