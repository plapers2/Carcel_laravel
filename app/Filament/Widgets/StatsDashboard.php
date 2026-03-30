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
            Stat::make('Prisioneros', prisoners::count())
                ->description('Total registrados')
                ->icon('heroicon-o-lock-closed'),

            Stat::make('Visitantes', visitors::count())
                ->description('Total registrados')
                ->icon('heroicon-o-user-group'),

            Stat::make('Visitas hoy', visits::whereDate('start_date', now())->count())
                ->description('Hoy')
                ->icon('heroicon-o-calendar'),

            Stat::make('Rechazadas', visits::where('verification', 'Desaprobada')->count())
                ->description('Total')
                ->icon('heroicon-o-x-circle'),
        ];
    }
}
