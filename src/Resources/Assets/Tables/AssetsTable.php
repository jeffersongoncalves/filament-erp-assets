<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Resources\Assets\Tables;

use Filament\Tables\Actions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Assets\Enums\AssetStatus;
use JeffersonGoncalves\Erp\Core\Enums\DocStatus;
use JeffersonGoncalves\FilamentErp\Assets\Concerns\PostsAssetDepreciation;
use JeffersonGoncalves\FilamentErp\Core\Concerns\SubmittableRecordActions;

class AssetsTable
{
    use PostsAssetDepreciation;
    use SubmittableRecordActions;

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset_name')
                    ->label('Asset Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('item_code')
                    ->label('Item Code')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('assetCategory.name')
                    ->label('Category')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('gross_purchase_amount')
                    ->label('Gross Amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('value_after_depreciation')
                    ->label('Book Value')
                    ->numeric()
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state instanceof AssetStatus ? $state->value : (string) $state)
                    ->color(fn ($state): string => match ($state) {
                        AssetStatus::Draft => 'gray',
                        AssetStatus::Submitted => 'info',
                        AssetStatus::PartiallyDepreciated => 'warning',
                        AssetStatus::FullyDepreciated => 'success',
                        AssetStatus::Scrapped => 'danger',
                        AssetStatus::Sold => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('docstatus')
                    ->label('Doc Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof DocStatus ? $state->name : $state)
                    ->color(fn ($state): string => match ($state) {
                        DocStatus::Draft => 'gray',
                        DocStatus::Submitted => 'success',
                        DocStatus::Cancelled => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('company.name')
                    ->label('Company')
                    ->toggleable()
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(self::statusOptions()),
                SelectFilter::make('docstatus')
                    ->label('Doc Status')
                    ->options([
                        0 => 'Draft',
                        1 => 'Submitted',
                        2 => 'Cancelled',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make()
                    ->visible(fn ($record): bool => $record->docstatus === DocStatus::Draft),
                ...self::submittableRecordActions(),
                self::postDepreciationAction(),
                Actions\DeleteAction::make()
                    ->visible(fn ($record): bool => $record->docstatus === DocStatus::Draft),
            ]);
    }

    /** @return array<string, string> */
    protected static function statusOptions(): array
    {
        $options = [];

        foreach (AssetStatus::cases() as $case) {
            $options[$case->value] = $case->value;
        }

        return $options;
    }
}
