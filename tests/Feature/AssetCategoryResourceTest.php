<?php

use JeffersonGoncalves\Erp\Accounting\Models\Account;
use JeffersonGoncalves\Erp\Assets\Enums\DepreciationMethod;
use JeffersonGoncalves\Erp\Assets\Models\AssetCategory;
use JeffersonGoncalves\Erp\Core\Models\Company;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetCategories\Pages\CreateAssetCategory;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetCategories\Pages\EditAssetCategory;
use JeffersonGoncalves\FilamentErp\Assets\Resources\AssetCategories\Pages\ListAssetCategories;
use Livewire\Livewire;

beforeEach(function () {
    filament()->setCurrentPanel(filament()->getPanel('admin'));

    $this->company = Company::factory()->create();
});

it('can render the asset category list page', function () {
    Livewire::test(ListAssetCategories::class)->assertSuccessful();
});

it('can render the asset category create page', function () {
    Livewire::test(CreateAssetCategory::class)->assertSuccessful();
});

it('can render the asset category edit page', function () {
    $category = AssetCategory::factory()->create();

    Livewire::test(EditAssetCategory::class, ['record' => $category->getRouteKey()])
        ->assertSuccessful();
});

it('can create an asset category with its depreciation accounts through the form', function () {
    $depreciation = Account::factory()->create(['company_id' => $this->company->id]);
    $accumulated = Account::factory()->create(['company_id' => $this->company->id]);
    $fixed = Account::factory()->create(['company_id' => $this->company->id]);

    Livewire::test(CreateAssetCategory::class)
        ->fillForm([
            'name' => 'Computers',
            'depreciation_method' => DepreciationMethod::StraightLine->value,
            'total_number_of_depreciations' => 36,
            'frequency_of_depreciation' => 1,
            'depreciation_account_id' => $depreciation->id,
            'accumulated_depreciation_account_id' => $accumulated->id,
            'fixed_asset_account_id' => $fixed->id,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $category = AssetCategory::query()->where('name', 'Computers')->first();

    expect($category)->not->toBeNull()
        ->and($category->depreciation_account_id)->toBe($depreciation->id)
        ->and($category->accumulated_depreciation_account_id)->toBe($accumulated->id)
        ->and($category->fixed_asset_account_id)->toBe($fixed->id);
});
