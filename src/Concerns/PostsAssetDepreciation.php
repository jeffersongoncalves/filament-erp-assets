<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Concerns;

use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use JeffersonGoncalves\Erp\Assets\Models\Asset;
use JeffersonGoncalves\Erp\Assets\Services\DepreciationService;
use JeffersonGoncalves\Erp\Core\Enums\DocStatus;

/**
 * The "Post Depreciation" record action for a submitted asset. It collects the
 * cut-off date in a modal, then hands off to
 * {@see DepreciationService::postDepreciation()} which posts every depreciation
 * period due on or before that date to the general ledger (a balanced entry per
 * period) and flags the corresponding schedule rows. Any failure (e.g. a
 * category missing its depreciation accounts) is surfaced as a Filament danger
 * notification.
 */
trait PostsAssetDepreciation
{
    public static function postDepreciationAction(): Action
    {
        return Action::make('postDepreciation')
            ->label('Post Depreciation')
            ->icon('heroicon-o-banknotes')
            ->color('primary')
            ->visible(fn (Model $record): bool => $record->getAttribute('docstatus') === DocStatus::Submitted)
            ->form([
                DatePicker::make('upto')
                    ->label('Post up to')
                    ->default(fn (): Carbon => Carbon::now())
                    ->required(),
            ])
            ->action(function (Model $record, array $data): void {
                if (! $record instanceof Asset) {
                    return;
                }

                $upto = isset($data['upto'])
                    ? Carbon::parse($data['upto'])
                    : Carbon::now();

                try {
                    app(DepreciationService::class)->postDepreciation($record, $upto);

                    Notification::make()
                        ->title('Depreciation posted')
                        ->body('Posted depreciation up to '.$upto->toDateString().'.')
                        ->success()
                        ->send();
                } catch (\Throwable $exception) {
                    Notification::make()
                        ->title('Unable to post depreciation')
                        ->body($exception->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }
}
