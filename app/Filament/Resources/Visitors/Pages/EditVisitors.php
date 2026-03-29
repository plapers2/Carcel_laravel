<?php

namespace App\Filament\Resources\Visitors\Pages;

use App\Filament\Resources\Visitors\VisitorsResource;
use App\Models\Visitors;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVisitors extends EditRecord
{
    protected static string $resource = VisitorsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    private function validarDocumento(array &$data): void
    {
        $validation = Visitors::where('identification_number', $data['identification_number'])->get();
        if ($validation) {
            \Filament\Notifications\Notification::make()
                ->title('Error')
                ->body('Ya existe un visitante con el numero de identificacion ingresado!')
                ->danger()
                ->send();
            $this->halt();
        }
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->validarDocumento($data);
        return $data;
    }
}
