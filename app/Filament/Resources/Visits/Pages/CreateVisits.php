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
        $data['verification'] = 'In progress';
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
    private function validateVisitTime(array $data): void
    {
        $hour = \Carbon\Carbon::parse($data['start_date'])->hour;

        if ($hour < 14 || $hour >= 17) {
            \Filament\Notifications\Notification::make()
                ->title('Error')
                ->body('Visits are only allowed between 14:00 and 17:00!')
                ->danger()
                ->send();
            $this->halt();
        }
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->validateSunday($data);
        $this->validateFutureDate($data);
        $this->validateVisitTime($data);
        $this->assignGuard($data);
        $this->assignVerification($data);

        return $data;
    }
}
