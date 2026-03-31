<?php

namespace App\Filament\Widgets;

use App\Models\prisoners;
use App\Models\visitors;
use App\Models\visits;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStats extends StatsOverviewWidget
{
    protected static bool $isDiscovered = false;
    protected function getStats(): array
    {
        return [
            Stat::make('Prisoners', prisoners::count())
                ->description('Total registered')
                ->icon('heroicon-o-lock-closed'),

            Stat::make('Visitors', visitors::count())
                ->description('Total registered')
                ->icon('heroicon-o-user-group'),

            Stat::make('Today Visits', visits::whereDate('start_date', now())->count())
                ->description('Today')
                ->icon('heroicon-o-calendar'),

            Stat::make('Rejected', visits::where('verification', 'Rejected')->count())
                ->description('Total')
                ->icon('heroicon-o-x-circle'),
        ];
    }
}
