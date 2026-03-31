<?php

namespace App\Filament\Widgets;

use App\Models\visits;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class GuardChart extends ChartWidget
{
    protected ?string $heading = 'Guard Chart';
    protected static bool $isDiscovered = false;

    protected function getData(): array
    {
        $userId = Auth::id();

        $data = collect(range(6, 0))->map(function ($daysAgo) use ($userId) {
            return visits::where('users_id', $userId)
                ->whereDate('start_date', now()->subDays($daysAgo))
                ->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'My Visits',
                    'data' => $data,
                ],
            ],
            'labels' => collect(range(6, 0))
                ->map(fn($d) => now()->subDays($d)->format('d/m')),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
