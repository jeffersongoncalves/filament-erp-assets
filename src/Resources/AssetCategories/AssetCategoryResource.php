<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Resources\AssetCategories;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Assets\Support\ModelResolver;
use JeffersonGoncalves\FilamentErp\Assets\FilamentErpAssetsPlugin;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetCategories\Pages\CreateAssetCategory;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetCategories\Pages\EditAssetCategory;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetCategories\Pages\ListAssetCategories;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetCategories\Schemas\AssetCategoryForm;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetCategories\Tables\AssetCategoriesTable;

class AssetCategoryResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModel(): string
    {
        return ModelResolver::assetCategory();
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
        return AssetCategoryForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return AssetCategoriesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssetCategories::route('/'),
            'create' => CreateAssetCategory::route('/create'),
            'edit' => EditAssetCategory::route('/{record}/edit'),
        ];
    }
}
