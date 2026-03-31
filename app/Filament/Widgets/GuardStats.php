<?php

namespace App\Filament\Widgets;

use App\Models\visits;
use Filament\Widgets\StatsOverviewWidget;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GuardStats extends StatsOverviewWidget
{
    protected static bool $isDiscovered = false;
    protected function getStats(): array
    {
        $userId = Auth::id();
        return [
            Stat::make(
                'My Visits',
                visits::where('users_id', $userId)->count()
            )
                ->description('Created by me')
                ->icon('heroicon-o-document'),

            Stat::make(
                'Approved by me',
                visits::where('users_id', $userId)
                    ->where('verification', 'Finished')
                    ->count()
            )
                ->description('Total')
                ->icon('heroicon-o-check-circle'),

            Stat::make(
                'Rejected by me',
                visits::where('users_id', $userId)
                    ->where('verification', 'Rejected')
                    ->count()
            )
                ->description('Total')
                ->icon('heroicon-o-x-circle'),

            Stat::make(
                'Today',
                visits::where('users_id', $userId)
                    ->whereDate('start_date', now())
                    ->count()
            )
                ->description('My visits today')
                ->icon('heroicon-o-calendar'),
        ];
    }
}
