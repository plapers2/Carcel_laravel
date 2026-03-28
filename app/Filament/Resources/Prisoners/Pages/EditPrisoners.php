<?php

namespace App\Filament\Resources\Prisoners\Pages;

use App\Filament\Resources\Prisoners\PrisonersResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPrisoners extends EditRecord
{
    protected static string $resource = PrisonersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
