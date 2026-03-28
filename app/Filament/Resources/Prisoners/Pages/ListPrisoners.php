<?php

namespace App\Filament\Resources\Prisoners\Pages;

use App\Filament\Resources\Prisoners\PrisonersResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPrisoners extends ListRecords
{
    protected static string $resource = PrisonersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
