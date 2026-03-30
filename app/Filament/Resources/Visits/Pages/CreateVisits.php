<?php

namespace App\Filament\Resources\Visits\Pages;

use App\Filament\Resources\Visits\VisitsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVisits extends CreateRecord
{
    protected static string $resource = VisitsResource::class;
    // Hook de Filament
    private function validateSunday(array &$data): void
    {
        $date = \Carbon\Carbon::parse($data['start_date']);

        if ($date->dayOfWeek !== \Carbon\Carbon::SUNDAY) {
            \Filament\Notifications\Notification::make()
                ->title('Error')
                ->body('Visits are only allowed on Sundays!')
                ->danger()
                ->send();
            $this->halt();
        }
    }
    private function assignGuard(array &$data): void
    {
        $data['users_id'] = auth()->id();
    }
    private function assignVerification(array &$data): void
    {
        $data['verification'] = 'En curso';
    }
    private function validateFutureDate(array &$data): void
    {
        if (\Carbon\Carbon::parse($data['start_date'])->isPast()) {
            \Filament\Notifications\Notification::make()
                ->title('Error')
                ->body('The date must be later than the current date!')
                ->danger()
                ->send();
            $this->halt();
        }
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->validateSunday($data['start_date']);
        $this->validateFutureDate($data);
        $this->assignGuard($data);
        $this->assignVerification($data);

        return $data;
    }
}
