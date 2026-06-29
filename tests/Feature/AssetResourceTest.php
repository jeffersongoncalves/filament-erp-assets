<?php

use JeffersonGoncalves\Erp\Accounting\Models\Account;
use JeffersonGoncalves\Erp\Accounting\Models\GlEntry;
use JeffersonGoncalves\Erp\Assets\Enums\DepreciationMethod;
use JeffersonGoncalves\Erp\Assets\Models\Asset;
use JeffersonGoncalves\Erp\Assets\Models\AssetCategory;
use JeffersonGoncalves\Erp\Core\Enums\DocStatus;
use JeffersonGoncalves\Erp\Core\Models\Company;
use JeffersonGoncalves\FilamentErp\Assets\Resources\Assets\Pages\CreateAsset;
use JeffersonGoncalves\FilamentErp\Assets\Resources\Assets\Pages\EditAsset;
use JeffersonGoncalves\FilamentErp\Assets\Resources\Assets\Pages\ListAssets;
use Livewire\Livewire;

beforeEach(function () {
    filament()->setCurrentPanel(filament()->getPanel('admin'));

    $this->company = Company::factory()->create();

    $this->depreciationAccount = Account::factory()->create(['company_id' => $this->company->id]);
    $this->accumulatedAccount = Account::factory()->create(['company_id' => $this->company->id]);
    $this->fixedAccount = Account::factory()->create(['company_id' => $this->company->id]);

    $this->category = AssetCategory::factory()->create([
        'depreciation_method' => DepreciationMethod::StraightLine,
        'total_number_of_depreciations' => 12,
        'frequency_of_depreciation' => 1,
        'depreciation_account_id' => $this->depreciationAccount->id,
        'accumulated_depreciation_account_id' => $this->accumulatedAccount->id,
        'fixed_asset_account_id' => $this->fixedAccount->id,
    ]);
});

function makeAsset(): Asset
{
    return Asset::factory()->create([
        'asset_name' => 'Server Rack',
        'asset_category_id' => test()->category->id,
        'company_id' => test()->company->id,
        'gross_purchase_amount' => 12000,
        'salvage_value' => 0,
        'depreciation_method' => DepreciationMethod::StraightLine,
        'total_number_of_depreciations' => 12,
        'frequency_of_depreciation' => 1,
        'purchase_date' => '2024-01-01',
        'available_for_use_date' => '2024-01-01',
    ]);
}

it('can render the asset list page', function () {
    Livewire::test(ListAssets::class)->assertSuccessful();
});

it('can render the asset create page', function () {
    Livewire::test(CreateAsset::class)->assertSuccessful();
});

it('can render the asset edit page', function () {
    $asset = makeAsset();

    Livewire::test(EditAsset::class, ['record' => $asset->getRouteKey()])
        ->assertSuccessful();
});

it('can create an asset through the form', function () {
    Livewire::test(CreateAsset::class)
        ->fillForm([
            'asset_name' => 'Forklift',
            'asset_category_id' => $this->category->id,
            'company_id' => $this->company->id,
            'gross_purchase_amount' => 25000,
            'salvage_value' => 1000,
            'depreciation_method' => DepreciationMethod::StraightLine->value,
            'total_number_of_depreciations' => 10,
            'frequency_of_depreciation' => 1,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Asset::query()->where('asset_name', 'Forklift')->exists())->toBeTrue();
});

it('submits an asset through the UI and builds its depreciation schedule', function () {
    $asset = makeAsset();

    Livewire::test(ListAssets::class)
        ->callTableAction('submit', $asset);

    $asset->refresh();

    expect($asset->docstatus)->toBe(DocStatus::Submitted)
        ->and($asset->depreciationSchedules)->toHaveCount(12)
        ->and($asset->value_after_depreciation)->toBe(0.0)
        ->and($asset->depreciationSchedules->first()->depreciation_amount)->toBe(1000.0);
});

it('posts depreciation for a submitted asset through the UI, writing balanced GL entries', function () {
    $asset = makeAsset();

    Livewire::test(ListAssets::class)
        ->callTableAction('submit', $asset);

    expect($asset->refresh()->docstatus)->toBe(DocStatus::Submitted)
        ->and($asset->depreciationSchedules)->toHaveCount(12);

    Livewire::test(ListAssets::class)
        ->callTableAction('postDepreciation', $asset, [
            'upto' => '2030-01-01',
        ]);

    $entries = GlEntry::query()
        ->where('voucherable_type', $asset->getMorphClass())
        ->where('voucherable_id', $asset->getKey())
        ->get();

    expect($entries)->toHaveCount(24)
        ->and(round((float) $entries->sum('debit'), 2))->toBe(12000.0)
        ->and(round((float) $entries->sum('credit'), 2))->toBe(12000.0)
        ->and(round((float) $entries->sum('debit'), 2))->toBe(round((float) $entries->sum('credit'), 2));

    $asset->refresh();

    expect($asset->depreciationSchedules->every(fn ($row): bool => $row->gl_posted === true))->toBeTrue();
});
