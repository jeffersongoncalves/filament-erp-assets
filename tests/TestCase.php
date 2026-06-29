<?php

namespace JeffersonGoncalves\FilamentErp\Assets\Tests;

use Composer\InstalledVersions;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use JeffersonGoncalves\Erp\Accounting\ErpAccountingServiceProvider;
use JeffersonGoncalves\Erp\Assets\ErpAssetsServiceProvider;
use JeffersonGoncalves\Erp\Core\ErpCoreServiceProvider;
use JeffersonGoncalves\FilamentErp\Assets\FilamentErpAssetsServiceProvider;
use JeffersonGoncalves\FilamentErp\Assets\Tests\Fixtures\TestPanelProvider;
use JeffersonGoncalves\FilamentErp\Assets\Tests\Fixtures\TestUser;
use JeffersonGoncalves\FilamentErp\Core\Testing\InteractsWithErpFilament;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use InteractsWithErpFilament;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rebindFilamentDataStore();

        // The domain factories ship in the vendored packages; resolve them by
        // basename across the Assets, Accounting and Core packages in turn.
        Factory::guessFactoryNamesUsing($this->erpFactoryResolver([
            'JeffersonGoncalves\\Erp\\Assets\\Database\\Factories',
            'JeffersonGoncalves\\Erp\\Accounting\\Database\\Factories',
            'JeffersonGoncalves\\Erp\\Core\\Database\\Factories',
        ]));

        Filament::setCurrentPanel(Filament::getDefaultPanel());

        $this->withoutVite();

        $this->actingAs(TestUser::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]));
    }

    protected function getPackageProviders($app): array
    {
        return array_merge($this->filamentTestProviders(), [
            ErpCoreServiceProvider::class,
            ErpAccountingServiceProvider::class,
            ErpAssetsServiceProvider::class,
            FilamentErpAssetsServiceProvider::class,
            TestPanelProvider::class,
        ]);
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);

        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
        $app['config']->set('auth.providers.users.model', TestUser::class);

        $coreConfig = InstalledVersions::getInstallPath('jeffersongoncalves/laravel-erp-core').'/config/erp-core.php';

        if (file_exists($coreConfig)) {
            $app['config']->set('erp-core', require $coreConfig);
        }

        $accountingConfig = InstalledVersions::getInstallPath('jeffersongoncalves/laravel-erp-accounting').'/config/erp-accounting.php';

        if (file_exists($accountingConfig)) {
            $app['config']->set('erp-accounting', require $accountingConfig);
        }

        $assetsConfig = InstalledVersions::getInstallPath('jeffersongoncalves/laravel-erp-assets').'/config/erp-assets.php';

        if (file_exists($assetsConfig)) {
            $app['config']->set('erp-assets', require $assetsConfig);
        }
    }

    protected function defineDatabaseMigrations(): void
    {
        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->default('');
            $table->rememberToken();
        });

        $this->loadErpVendorMigrations([
            'core' => [
                'create_erp_companies_table',
                'create_erp_currencies_table',
                'create_erp_currency_exchanges_table',
                'create_erp_uoms_table',
                'create_erp_uom_conversions_table',
                'create_erp_fiscal_years_table',
                'create_erp_departments_table',
                'create_erp_designations_table',
                'create_erp_brands_table',
                'create_erp_terms_and_conditions_table',
                'create_erp_addresses_table',
                'create_erp_contacts_table',
                'create_erp_naming_series_table',
            ],
            'accounting' => [
                'create_erp_accounts_table',
                'create_erp_cost_centers_table',
                'create_erp_payment_terms_table',
                'create_erp_modes_of_payment_table',
                'create_erp_tax_templates_table',
                'create_erp_tax_template_taxes_table',
                'create_erp_banks_table',
                'create_erp_bank_accounts_table',
                'create_erp_budgets_table',
                'create_erp_budget_accounts_table',
                'create_erp_gl_entries_table',
                'create_erp_journal_entries_table',
                'create_erp_journal_entry_accounts_table',
                'create_erp_payment_entries_table',
                'create_erp_sales_invoices_table',
                'create_erp_sales_invoice_items_table',
                'create_erp_sales_invoice_taxes_table',
                'create_erp_purchase_invoices_table',
                'create_erp_purchase_invoice_items_table',
                'create_erp_purchase_invoice_taxes_table',
                'create_erp_period_closing_vouchers_table',
                'create_erp_bank_transactions_table',
            ],
            'assets' => [
                'create_erp_asset_categories_table',
                'create_erp_assets_table',
                'create_erp_asset_depreciation_schedules_table',
                'create_erp_asset_movements_table',
                'create_erp_asset_repairs_table',
            ],
        ]);
    }
}
