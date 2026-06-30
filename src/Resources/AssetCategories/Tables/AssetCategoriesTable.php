<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Resources\AssetCategories\Tables;

use Filament\Actions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssetCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('depreciation_method')
                    ->label('Method')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state instanceof \BackedEnum ? (string) $state->value : (string) $state)
                    ->sortable(),
                TextColumn::make('total_number_of_depreciations')
                    ->label('Periods')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('frequency_of_depreciation')
                    ->label('Frequency')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('depreciationAccount.name')
                    ->label('Depreciation Account')
                    ->toggleable(),
            ])
            ->defaultSort('name')
            ->recordActions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
