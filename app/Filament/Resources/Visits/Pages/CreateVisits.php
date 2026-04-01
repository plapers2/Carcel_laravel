<?php

namespace App\Filament\Resources\Visits\Pages;

use App\Filament\Resources\Visits\VisitsResource;
use App\Models\Visits;
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
        $data['verification'] = 'Pending';
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
    private function validateVisitRangeOfTime(array $data): void
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
    private function assignEndDate(array &$data): void
    {
        $end = \Carbon\Carbon::parse($data['start_date'])->addMinutes(30)->hour;
        if ($end < 17) {
            $data['end_date'] = \Carbon\Carbon::parse($data['start_date'])->addMinutes(30);
        } else {
            $data['end_date'] = \Carbon\Carbon::parse($data['start_date'])->setTime(17, 0, 0);
        }
    }
    private function validateAvailability(array &$data): void
    {
        $start = \Carbon\Carbon::parse($data['start_date']);
        $end = $start->copy()->addMinutes(30);
        $conflict = Visits::where('prisoners_id', $data['prisoners_id'])
            ->where('start_date', '<', $end)
            ->where('end_date', '>', $start)
            ->exists();
        if ($conflict) {
            \Filament\Notifications\Notification::make()
                ->title('Error')
                ->body('This prisoner already has a visit scheduled at this time.')
                ->danger()
                ->send();
            $this->halt();
        }
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->validateSunday($data);
        $this->validateFutureDate($data);
        $this->validateVisitRangeOfTime($data);
        $this->validateAvailability($data);
        $this->assignEndDate($data);
        $this->assignGuard($data);
        $this->assignVerification($data);

        return $data;
    }
}
