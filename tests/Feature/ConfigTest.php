<?php

it('loads the filament-erp-assets config file', function () {
    expect(config('filament-erp-assets'))->toBeArray();
});

it('has a default navigation group', function () {
    expect(config('filament-erp-assets.navigation_group'))->toBe('ERP — Assets');
});

it('registers all resources in config', function () {
    $resources = config('filament-erp-assets.resources');

    expect($resources)->toBeArray()
        ->toHaveKeys([
            'asset_category',
            'asset',
            'asset_movement',
            'asset_repair',
        ]);
});

it('registers the dashboard widgets in config', function () {
    expect(config('filament-erp-assets.widgets'))->toBeArray()
        ->toHaveKeys(['asset_stats']);
});
