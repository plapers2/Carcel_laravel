<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class Dashboard extends BaseDashboard
{

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('admin');
    }
    protected static bool $shouldRegisterNavigation = true;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Home;

    protected static ?string $title = 'Dashboard';
}
