<?php

namespace App\Filament\Resources\HistorialSessions\Pages;

use App\Filament\Resources\HistorialSessions\HistorialSessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHistorialSessions extends ListRecords
{
    protected static string $resource = HistorialSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
