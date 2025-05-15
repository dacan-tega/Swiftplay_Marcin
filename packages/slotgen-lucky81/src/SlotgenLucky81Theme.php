<?php

namespace Slotgen\SlotgenLucky81;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Assets\Theme;
use Filament\Support\Color;
use Filament\Support\Facades\FilamentAsset;

class SlotgenLucky81 implements Plugin
{
    public function getId(): string
    {
        return 'slotgen-lucky81';
    }

    public function register(Panel $panel): void
    {
        FilamentAsset::register([
            Theme::make('slotgen-lucky81', __DIR__ . '/../resources/dist/slotgen-lucky81.css'),
        ]);

        $panel
            ->font('DM Sans')
            ->primaryColor(Color::Amber)
            ->secondaryColor(Color::Gray)
            ->warningColor(Color::Amber)
            ->dangerColor(Color::Rose)
            ->successColor(Color::Green)
            ->grayColor(Color::Gray)
            ->theme('slotgen-lucky81');
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
