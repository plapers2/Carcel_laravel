<?php

namespace App\Filament\Resources\Visits\Pages;

use App\Filament\Resources\Visits\VisitsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVisits extends EditRecord
{
    protected static string $resource = VisitsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
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
    private function asignarHoraFinVisita(array &$data): void
    {
        $start_date = $this->getRecord()->start_date;
        if ($data['verification'] == 'Terminada') {
            if ($start_date < now()) {
                $data['end_date'] = now();
            } else {
                \Filament\Notifications\Notification::make()
                    ->title('Error')
                    ->body('La visita no se ah realizado aun, no se puede terminar!.')
                    ->danger()
                    ->send();
                $this->halt();
            }
        } else {
            $data['end_date'] = $start_date;
        }
    }

    private function asignarGuardia(array &$data): void
    {
        $data['users_id'] = auth()->id();
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->validarDomingo($this->getRecord()->start_date);
        $this->asignarGuardia($data);
        $this->asignarHoraFinVisita($data);
        return $data;
    }
}
