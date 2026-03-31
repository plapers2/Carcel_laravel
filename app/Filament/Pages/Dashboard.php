<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AdminStats;
use App\Filament\Widgets\AdminTable;
use App\Filament\Widgets\AdminChart;
use App\Filament\Widgets\GuardChart;
use App\Filament\Widgets\GuardStats;
use App\Filament\Widgets\GuardTable;
use Filament\Pages\Dashboard as BaseDashboard;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{


    protected static bool $shouldRegisterNavigation = true;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Home;

    protected static ?string $title = 'Dashboard';

    protected function getHeaderWidgets(): array
    {
        $user = Auth::user();

        return match (true) {
            $user?->hasRole('admin') => [
                AdminStats::class,
                AdminTable::class,
                AdminChart::class,
            ],

            $user?->hasRole('guard') => [
                GuardStats::class,
                GuardTable::class,
                GuardChart::class,
            ],

            default => [],
        };
    }
}
