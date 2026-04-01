<?php

namespace App\Filament\Widgets;

use App\Models\visits;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class AdminChart extends ChartWidget
{
    protected ?string $heading = 'Visits of the last 7 days';
    protected static bool $isDiscovered = false;

    protected function getData(): array
    {
        $data = collect(range(6, 0))->map(function ($daysAgo) {
            return visits::whereDate('start_date', Carbon::now()->subDays($daysAgo))->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Visitas',
                    'data' => $data,
                ],
            ],
            'labels' => collect(range(6, 0))->map(fn($d) => now()->subDays($d)->format('d/m')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
