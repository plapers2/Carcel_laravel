<?php

namespace App\Filament\Resources\Prisoners\Pages;

use App\Filament\Resources\Prisoners\PrisonersResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VisitasExport;

class ViewPrisoners extends ViewRecord
{
    protected static string $resource = PrisonersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportHistory')
                ->label('Export Visit History')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $prisoner = $this->record;

                    $visits = $prisoner->visits()
                        ->with(['visitor'])
                        ->latest()
                        ->get();

                    return Excel::download(
                        new VisitasExport($visits),
                        'prisoner_visit_history.xlsx'
                    );
                })->visible(fn() => auth()->user()?->hasRole('admin')),
            Action::make('exportPdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document')
                ->color('danger')
                ->action(function () {
                    $prisoner = $this->record;

                    $datos = $prisoner->visits()->with('visitor')->get();

                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
                        'reportes.visitas',
                        compact('datos')
                    );

                    return response()->streamDownload(
                        fn() => print($pdf->output()),
                        'prisoner_visit_history.pdf'
                    );
                })->visible(fn() => auth()->user()?->hasRole('admin')),
        ];
    }
}
