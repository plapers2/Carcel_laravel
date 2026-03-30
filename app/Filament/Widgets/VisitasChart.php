<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\visits;
use Carbon\Carbon;

class VisitasChart extends ChartWidget
{
    protected ?string $heading = 'Visitas últimos 7 días';

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
