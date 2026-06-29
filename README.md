<div class="filament-hidden">

![Filament ERP Assets](https://raw.githubusercontent.com/jeffersongoncalves/filament-erp-assets/2.x/art/jeffersongoncalves-filament-erp-assets.png)

</div>

# Filament ERP Assets

Filament v4 panel resources for the [Laravel ERP assets module](https://github.com/jeffersongoncalves/laravel-erp-assets) — fixed asset register, depreciation and movements.

This package is the UI layer for the `jeffersongoncalves/laravel-erp-assets` domain package (namespace `JeffersonGoncalves\Erp\Assets\`). It wires the fixed-asset models into ready-to-use Filament resources, with Submit/Cancel actions that drive the document lifecycle and post depreciation.

## Features

- **Asset register** — Asset categories and assets, with a depreciation schedule relation manager
- **Movements & repairs** — Track asset movements and repairs
- **Document lifecycle** — Submit/Cancel record actions wired to the domain `submit()` / `cancel()` methods, with depreciation posted on submit
- **Dashboard widget** — `AssetStatsWidget` with asset counts and value
- **Configurable** — Swap resource classes, change the navigation group or assign a cluster via config

## Compatibility

| Package | PHP | Filament | Laravel |
|---------|-----|----------|---------|
| `^3.0`  | `^8.2` | `^5.0` | `^11.0 \| ^12.0 \| ^13.0` |
| `^2.0`  | `^8.2` | `^4.0` | `^11.0 \| ^12.0 \| ^13.0` |

## Installation

Install the package via Composer:

```bash
composer require jeffersongoncalves/filament-erp-assets
```

Register the plugin on a Filament panel:

```php
use JeffersonGoncalves\FilamentErp\Assets\FilamentErpAssetsPlugin;

$panel->plugin(
    FilamentErpAssetsPlugin::make()
        ->navigationGroup('ERP — Assets'),
);
```

## Resources

| Resource | Purpose |
|----------|---------|
| `AssetCategoryResource` | Asset categories (depreciation defaults) |
| `AssetResource` | Assets (+ Depreciation Schedule RM, Submit/Cancel) |
| `AssetMovementResource` | Asset movements (Submit/Cancel) |
| `AssetRepairResource` | Asset repairs (Submit/Cancel) |

Transaction resources expose **Submit** and **Cancel** record actions that drive the domain document lifecycle (`$record->submit()` / `$record->cancel()`); submitting an asset posts its depreciation schedule.

## Widgets

| Widget | Purpose |
|--------|---------|
| `AssetStatsWidget` | Count and value of registered assets |

## Configuration

Publish the config to swap resource classes, change the navigation group, or adjust widgets:

```bash
php artisan vendor:publish --tag="filament-erp-assets-config"
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Jefferson Simão Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
