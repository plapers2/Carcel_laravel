<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Support\Icons\Heroicon;
use App\Models\visits;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\DatePicker;
use App\Exports\VisitasExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;

class Reportes extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Document;
    protected static ?string $navigationLabel = 'Visits';
    protected static string|\UnitEnum|null $navigationGroup = 'Reportes';
    protected string $view = 'filament.pages.reportes';
    protected static ?int $navigationSort = 1;
    protected static ?string $title = 'Reports of Visits';

    protected static bool $shouldRegisterNavigation = true;
    public ?array $data = [];

    public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->hasRole('admin');
    }

    protected function getFormSchema(): array
    {
        return [
            DatePicker::make('start_date')->required(),
            DatePicker::make('end_date')->required(),
        ];
    }


    protected function getActions(): array
    {
        return [
            Action::make('pdf')
                ->label('Export PDF')
                ->color('danger')
                ->action('exportPDF'),

            Action::make('excel')
                ->label('Export Excel')
                ->color("success")
                ->action('exportExcel'),
        ];
    }

    public function mount(): void
    {
        $this->form->fill([
            'start_date' => null,
            'end_date' => null,
        ]);
    }

    public function submit()
    {
        $data = $this->form->getState();

        dd($data);
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    public function getDatos()
    {

        $data = $this->form->getState();

        $inicio = $data['start_date'];
        $fin = $data['end_date'];

        if ($inicio > $fin) {
            throw new \Exception('La fecha inicio no puede ser mayor que la final');
        }

        return visits::with(['prisoner', 'visitor'])
            ->where(function ($query) use ($inicio, $fin) {
                $query
                    // empieza dentro del rango
                    ->whereBetween('start_date', [$inicio, $fin])

                    // O termina dentro del rango
                    ->orWhereBetween('end_date', [$inicio, $fin])

                    // O abarca todo el rango
                    ->orWhere(function ($q) use ($inicio, $fin) {
                        $q->where('start_date', '<=', $inicio)
                            ->where(function ($q2) use ($fin) {
                                $q2->where('end_date', '>=', $fin)
                                    ->orWhereNull('end_date'); // visitas activas
                            });
                    });
            })
            ->get();
    }

    public function exportExcel()
    {
        return Excel::download(
            new VisitasExport($this->getDatos()),
            'reporte_visitas.xlsx'
        );
    }


    public function exportPDF()
    {
        $datos = $this->getDatos();

        $pdf = Pdf::loadView('reportes.visitas', compact('datos'));

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'reporte_visitas.pdf'
        );
    }
}
