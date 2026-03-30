<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VisitasExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $datos;

    public function __construct($datos)
    {
        $this->datos = $datos;
    }

    public function collection()
    {
        return $this->datos->map(function ($v) {
            return [
                'Prisionero' => $v->prisoner->name ?? '',
                'Visitante' => $v->visitor->name ?? '',
                'Relationship' => $v->visitor_relationship,
                'Start Date' => \Carbon\Carbon::parse($v->start_date)->format('d/m/Y H:i'),
                'End Date' => $v->end_date
                    ? \Carbon\Carbon::parse($v->end_date)->format('d/m/Y H:i')
                    : 'In progress',
                'Estado' => $v->verification,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Prisionero',
            'Visitante',
            'Relación',
            'Fecha Inicio',
            'Fecha Fin',
            'Estado',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->datos->count() + 1;

        // Encabezados
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true],
        ]);

        // Bordes
        $sheet->getStyle("A1:F{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                ],
            ],
        ]);

        // Centrado
        $sheet->getStyle("A1:F{$lastRow}")->applyFromArray([
            'alignment' => [
                'horizontal' => 'center',
            ],
        ]);

        // 🎨 COLORES POR ESTADO (columna F)
        $row = 2; // empieza después del header

        foreach ($this->datos as $visita) {
            $color = null;

            switch ($visita->verification) {
                case 'Terminada':
                    $color = 'C6EFCE'; // verde claro
                    break;

                case 'En curso':
                    $color = 'FFF3CD'; // amarillo
                    break;

                case 'Desaprobada':
                    $color = 'F8D7DA'; // rojo claro
                    break;
            }

            if ($color) {
                $sheet->getStyle("F{$row}")->applyFromArray([
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => $color],
                    ],
                ]);
            }

            $row++;
        }
    }
}
