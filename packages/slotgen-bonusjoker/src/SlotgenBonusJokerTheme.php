<?php

namespace Slotgen\SlotgenBonusJoker;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Assets\Theme;
use Filament\Support\Color;
use Filament\Support\Facades\FilamentAsset;

class SlotgenBonusJoker implements Plugin
{
    public function getId(): string
    {
        return 'slotgen-bonusjoker';
    }

    public function register(Panel $panel): void
    {
        FilamentAsset::register([
            Theme::make('slotgen-bonusjoker', __DIR__ . '/../resources/dist/slotgen-bonusjoker.css'),
        ]);

        $panel
            ->font('DM Sans')
            ->primaryColor(Color::Amber)
            ->secondaryColor(Color::Gray)
            ->warningColor(Color::Amber)
            ->dangerColor(Color::Rose)
            ->successColor(Color::Green)
            ->grayColor(Color::Gray)
            ->theme('slotgen-bonusjoker');
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
