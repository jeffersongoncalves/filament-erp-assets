<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Resources\Assets\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use JeffersonGoncalves\Erp\Assets\Enums\DepreciationMethod;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(null)
            ->components([
                Section::make('Details')
                    ->schema([
                        TextInput::make('asset_name')
                            ->label('Asset Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('item_code')
                            ->label('Item Code')
                            ->maxLength(255),
                        Select::make('asset_category_id')
                            ->label('Asset Category')
                            ->relationship('assetCategory', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        TextInput::make('location')
                            ->label('Location')
                            ->maxLength(255),
                        TextInput::make('custodian')
                            ->label('Custodian')
                            ->maxLength(255),
                        DatePicker::make('purchase_date')
                            ->label('Purchase Date'),
                        DatePicker::make('available_for_use_date')
                            ->label('Available For Use Date'),
                    ])->columns(2),
                Section::make('Depreciation')
                    ->schema([
                        TextInput::make('gross_purchase_amount')
                            ->label('Gross Purchase Amount')
                            ->numeric()
                            ->default(0),
                        TextInput::make('salvage_value')
                            ->label('Salvage Value')
                            ->numeric()
                            ->default(0),
                        Select::make('depreciation_method')
                            ->label('Depreciation Method')
                            ->options(self::depreciationMethodOptions())
                            ->default(DepreciationMethod::StraightLine->value)
                            ->nullable(),
                        TextInput::make('total_number_of_depreciations')
                            ->label('Total Number of Depreciations')
                            ->numeric()
                            ->integer()
                            ->default(0),
                        TextInput::make('frequency_of_depreciation')
                            ->label('Frequency of Depreciation (months)')
                            ->numeric()
                            ->integer()
                            ->default(12),
                        TextInput::make('value_after_depreciation')
                            ->label('Value After Depreciation')
                            ->numeric()
                            ->readOnly()
                            ->dehydrated(false),
                    ])->columns(2),
            ]);
    }

    /** @return array<string, string> */
    protected static function depreciationMethodOptions(): array
    {
        $options = [];

        foreach (DepreciationMethod::cases() as $case) {
            $options[$case->value] = $case->value;
        }

        return $options;
    }
}
