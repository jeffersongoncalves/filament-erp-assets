<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Resources\AssetMovements\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use JeffersonGoncalves\Erp\Assets\Enums\AssetMovementPurpose;

class AssetMovementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(null)
            ->components([
                Section::make('Details')
                    ->schema([
                        Select::make('asset_id')
                            ->label('Asset')
                            ->relationship('asset', 'asset_name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('purpose')
                            ->label('Purpose')
                            ->options(self::purposeOptions())
                            ->default(AssetMovementPurpose::Transfer->value)
                            ->required(),
                        DateTimePicker::make('transaction_date')
                            ->label('Transaction Date')
                            ->required(),
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ])->columns(2),
                Section::make('Movement')
                    ->schema([
                        TextInput::make('from_location')
                            ->label('From Location')
                            ->maxLength(255),
                        TextInput::make('to_location')
                            ->label('To Location')
                            ->maxLength(255),
                        TextInput::make('from_custodian')
                            ->label('From Custodian')
                            ->maxLength(255),
                        TextInput::make('to_custodian')
                            ->label('To Custodian')
                            ->maxLength(255),
                    ])->columns(2),
            ]);
    }

    /** @return array<string, string> */
    protected static function purposeOptions(): array
    {
        $options = [];

        foreach (AssetMovementPurpose::cases() as $case) {
            $options[$case->value] = $case->value;
        }

        return $options;
    }
}
