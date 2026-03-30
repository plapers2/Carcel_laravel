<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\prisoners;
use App\Models\visitors;
use App\Models\visits;

class StatsDashboard extends BaseWidget
{
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
