<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{


    protected static bool $shouldRegisterNavigation = true;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Home;

    protected static ?string $title = 'Dashboard';

    public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->hasRole('admin');
    }

}
