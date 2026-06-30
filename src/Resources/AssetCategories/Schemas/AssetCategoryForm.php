<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Resources\AssetCategories\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use JeffersonGoncalves\Erp\Assets\Enums\DepreciationMethod;

class AssetCategoryForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->columns(null)
            ->schema([
                Section::make('Details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255),
                        Select::make('depreciation_method')
                            ->label('Depreciation Method')
                            ->options(self::depreciationMethodOptions())
                            ->default(DepreciationMethod::StraightLine->value)
                            ->required(),
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
                    ])->columns(2),
                Section::make('Accounts')
                    ->schema([
                        Select::make('depreciation_account_id')
                            ->label('Depreciation Account')
                            ->relationship('depreciationAccount', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Select::make('accumulated_depreciation_account_id')
                            ->label('Accumulated Depreciation Account')
                            ->relationship('accumulatedDepreciationAccount', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Select::make('fixed_asset_account_id')
                            ->label('Fixed Asset Account')
                            ->relationship('fixedAssetAccount', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
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
