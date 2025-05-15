<?php

namespace Slotgen\SlotgenLucky81;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Slotgen\SlotgenLucky81\Commands\SlotgenLucky81Command;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SlotgenLucky81ServiceProvider extends PackageServiceProvider
{
    public static string $name = 'slotgen-lucky81';

    public static string $viewNamespace = 'slotgen-lucky81';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasRoute('api-client')
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('slotgen/slotgen-lucky81');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void
    {
    }

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {// foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
            //     $this->publishes([
            //         $file->getRealPath() => base_path("stubs/slotgen-lucky81/{$file->getFilename()}"),
            //     ], 'slotgen-lucky81-stubs');
            // }
        }
    }

    protected function getAssetPackageName(): ?string
    {
        return 'slotgen/slotgen-lucky81';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('slotgen-lucky81', __DIR__ . '/../resources/dist/components/slotgen-lucky81.js'),
            // Css::make('slotgen-lucky81-styles', __DIR__ . '/../resources/dist/slotgen-lucky81.css'),
            // Js::make('slotgen-lucky81-scripts', __DIR__ . '/../resources/dist/slotgen-lucky81.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            // SlotgenLucky81Command::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_slotgen_lucky_81_configs_table',
            'create_lucky_81_players_table',
            'create_lucky_81_spin_logs_table',
            'add_value_buy_feature_to_slotgen_lucky_81_configs',
            'add_rtp_to_slotgen_lucky_81_spin_logs',
        ];
    }
}
