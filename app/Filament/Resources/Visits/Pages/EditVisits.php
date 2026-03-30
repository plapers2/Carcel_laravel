<?php

namespace App\Filament\Resources\Visits\Pages;

use App\Filament\Resources\Visits\VisitsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Carbon\Carbon;
use Filament\Notifications\Notification;

class EditVisits extends EditRecord
{
    protected static string $resource = VisitsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    private function assignEndTime(array &$data): void
    {
        $start_date = Carbon::parse($this->getRecord()->start_date);
        if ($data['verification'] === 'Finished') {
            if ($start_date->isPast()) {
                $data['end_date'] = now();
            } else {
                Notification::make()
                    ->title('Error')
                    ->body('The visit has not taken place yet, it cannot be marked as finished.')
                    ->danger()
                    ->send();
                $this->halt();
            }
        } else {
            $data['end_date'] = $start_date;
        }
    }
    private function assignGuard(array &$data): void
    {
        $data['users_id'] = auth()->id();
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->assignGuard($data);
        $this->assignEndTime($data);
        return $data;
    }
}
