<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use JeffersonGoncalves\Erp\Assets\Support\ModelResolver;
use JeffersonGoncalves\Erp\Core\Enums\DocStatus;

/**
 * A snapshot of the fixed-asset register: how many assets are on the books
 * (submitted), what they cost, and their remaining book value after
 * depreciation.
 */
class AssetStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $assetModel = ModelResolver::asset();

        $submitted = $assetModel::query()
            ->where('docstatus', DocStatus::Submitted->value);

        $count = (clone $submitted)->count();
        $gross = (float) (clone $submitted)->sum('gross_purchase_amount');
        $bookValue = (float) (clone $submitted)->sum('value_after_depreciation');

        return [
            Stat::make('Submitted Assets', (string) $count)
                ->description('on the books')
                ->color($count > 0 ? 'primary' : 'gray'),
            Stat::make('Gross Purchase Amount', number_format($gross, 2))
                ->description('total acquisition cost')
                ->color('success'),
            Stat::make('Net Book Value', number_format($bookValue, 2))
                ->description('after depreciation')
                ->color('info'),
        ];
    }
}
