<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\DatePicker;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

use App\Models\visits;
use App\Exports\VisitasExport;

use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class Reportes extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Document;
    protected static ?string $navigationLabel = 'Visits';
    protected static string|\UnitEnum|null $navigationGroup = 'Documents';
    protected static ?string $title = 'Reports of Visits';
    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.reportes';

    public ?array $data = [];
    public ?Collection $resultados = null;

    /**
     * Control de acceso
     */
    public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->hasRole('admin');
    }

    /**
     * Formulario
     */
    protected function getFormSchema(): array
    {
        return [
            DatePicker::make('start_date')
                ->label('Fecha inicio')
                ->required()
                ->maxDate(fn(callable $get) => $get('end_date')),

            DatePicker::make('end_date')
                ->label('Fecha fin')
                ->required()
                ->minDate(fn(callable $get) => $get('start_date')),
        ];
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    public function mount(): void
    {
        $this->form->fill([
            'start_date' => null,
            'end_date' => null,
        ]);
    }

    /**
     * Acciones (botones)
     */
    protected function getActions(): array
    {
        return [
            Action::make('pdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document')
                ->color('danger')
                ->action('exportPDF'),

            Action::make('excel')
                ->label('Export Excel')
                ->icon('heroicon-o-table-cells')
                ->color('success')
                ->action('exportExcel'),
        ];
    }

    /**
     * Obtener filtros
     */
    protected function getFiltros(): array
    {
        return $this->form->getState();
    }

    /**
     * Validación centralizada
     */
    protected function validarFiltros(): bool
    {
        ['start_date' => $inicio, 'end_date' => $fin] = $this->getFiltros();

        if (!$inicio || !$fin) {
            Notification::make()
                ->title('Debes seleccionar ambas fechas')
                ->danger()
                ->send();

            return false;
        }

        return true;
    }

    /**
     * Consulta optimizada
     */
    public function getDatos(): Collection
    {
        ['start_date' => $inicio, 'end_date' => $fin] = $this->getFiltros();

        return visits::query()
            ->with(['prisoner', 'visitor'])
            ->where(function ($query) use ($inicio, $fin) {
                $query->whereBetween('start_date', [$inicio, $fin])
                    ->orWhereBetween('end_date', [$inicio, $fin])
                    ->orWhere(function ($q) use ($inicio, $fin) {
                        $q->where('start_date', '<=', $inicio)
                            ->where(function ($q2) use ($fin) {
                                $q2->where('end_date', '>=', $fin)
                                    ->orWhereNull('end_date');
                            });
                    });
            })
            ->latest()
            ->get();
    }

    /**
     * Evita repetir consultas
     */
    protected function getCachedDatos(): Collection
    {
        return $this->resultados ?? $this->getDatos();
    }

    /**
     * Exportar Excel
     */
    public function exportExcel()
    {
        if (!$this->validarFiltros()) {
            return;
        }

        return Excel::download(
            new VisitasExport($this->getCachedDatos()),
            'reporte_visitas.xlsx'
        );
    }

    /**
     * Exportar PDF
     */
    public function exportPDF()
    {
        if (!$this->validarFiltros()) {
            return;
        }

        $datos = $this->getCachedDatos();

        $pdf = Pdf::loadView('reportes.visitas', compact('datos'));

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'reporte_visitas.pdf'
        );
    }
}
