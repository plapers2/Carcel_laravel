<?php

namespace App\Filament\Resources\Visits\Pages;

use App\Filament\Resources\Visits\VisitsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVisits extends CreateRecord
{
    protected static string $resource = VisitsResource::class;
    // Hook de Filament
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->validarDomingo($data['start_date']);
        $this->validarFecha($data);
        $this->asignarGuardia($data);
        $this->asignarVerificacion($data);

        return $data;
    }
    private function validarDomingo(string $date): void
    {
        $date = \Carbon\Carbon::parse($date);

        if ($date->dayOfWeek !== \Carbon\Carbon::SUNDAY) {
            \Filament\Notifications\Notification::make()
                ->title('Error')
                ->body('Las visitas solo se permiten los domingos.')
                ->danger()
                ->send();
            $this->halt();
        }
    }
    private function asignarGuardia(array &$data): void
    {
        $data['users_id'] = auth()->id();
    }
    private function asignarVerificacion(array &$data): void
    {
        $data['verification'] = 'En curso';
    }
    private function validarFecha(array &$data): void
    {
        if ($data['start_date'] < now()) {
            \Filament\Notifications\Notification::make()
                ->title('Error')
                ->body('La fecha debe ser mayor a la actual!.')
                ->danger()
                ->send();
            $this->halt();
        }
    }
}
