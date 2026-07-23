<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Resources\AssetRepairs\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class AssetRepairForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->columns(null)
            ->schema([
                Section::make('Details')
                    ->schema([
                        Select::make('asset_id')
                            ->label('Asset')
                            ->relationship('asset', 'asset_name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        DateTimePicker::make('failure_date')
                            ->label('Failure Date'),
                        TextInput::make('repair_status')
                            ->label('Repair Status')
                            ->default('Pending')
                            ->maxLength(255),
                        TextInput::make('repair_cost')
                            ->label('Repair Cost')
                            ->numeric()
                            ->default(0),
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Textarea::make('description')
                            ->label('Description')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
