<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Resources\Assets\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DepreciationScheduleRelationManager extends RelationManager
{
    protected static string $relationship = 'depreciationSchedules';

    protected static ?string $title = 'Depreciation Schedule';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('schedule_date')
            ->columns([
                TextColumn::make('schedule_date')
                    ->label('Schedule Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('depreciation_amount')
                    ->label('Depreciation')
                    ->numeric(),
                TextColumn::make('accumulated_depreciation_amount')
                    ->label('Accumulated')
                    ->numeric(),
                IconColumn::make('gl_posted')
                    ->label('GL Posted')
                    ->boolean(),
            ])
            ->defaultSort('schedule_date');
    }
}
