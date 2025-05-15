<?php

namespace Slotgen\SlotgenLucky81;

use Filament\Contracts\Plugin;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Slotgen\SlotgenLucky81\Filament\Pages\SlotgenLucky81ConfigPage;

class SlotgenLucky81Plugin implements Plugin
{
    public function getId(): string
    {
        return 'slotgen-lucky81';
    }

    public function register(Panel $panel): void
    {
        $panel->pages([
            SlotgenLucky81ConfigPage::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function getNavigationItems(): NavigationGroup
    {
        return NavigationGroup::make('Lucky 81')
            ->items([
                NavigationItem::make('fortune-tiger')
                    ->icon('heroicon-o-key')
                    ->label(fn (): string => 'Setting')
                    ->url(fn (): string => SlotgenLucky81ConfigPage::getUrl())
                    ->visible(true),
            ]);
    }
}
