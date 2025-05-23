<?php

namespace Slotgen\SlotgenBonusJoker;

use Filament\Contracts\Plugin;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Slotgen\SlotgenBonusJoker\Filament\Pages\SlotgenBonusJokerConfigPage;

class SlotgenBonusJokerPlugin implements Plugin
{
    public function getId(): string
    {
        return 'slotgen-bonusjoker';
    }

    public function register(Panel $panel): void
    {
        $panel->pages([
            SlotgenBonusJokerConfigPage::class,
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
        return NavigationGroup::make('Bonus Joker')
            ->items([
                NavigationItem::make('fortune-tiger')
                    ->icon('heroicon-o-key')
                    ->label(fn (): string => 'Setting')
                    ->url(fn (): string => SlotgenBonusJokerConfigPage::getUrl())
                    ->visible(true),
            ]);
    }
}
