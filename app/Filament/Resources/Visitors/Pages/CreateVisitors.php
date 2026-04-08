<?php

namespace App\Filament\Resources\Visitors\Pages;

use App\Filament\Resources\Visitors\VisitorsResource;
use App\Models\Visitors;
use Filament\Resources\Pages\CreateRecord;

class CreateVisitors extends CreateRecord
{
    protected static string $resource = VisitorsResource::class;
    private function validarDocumento(array &$data): void
    {
        $validation = Visitors::where('identification_number', $data['identification_number'])->exists();
        if ($validation) {
            \Filament\Notifications\Notification::make()
                ->title('Error')
                ->body('Ya existe un visitante con el numero de identificacion ingresado!')
                ->danger()
                ->send();
            $this->halt();
        }
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->validarDocumento($data);
        return $data;
    }
}
