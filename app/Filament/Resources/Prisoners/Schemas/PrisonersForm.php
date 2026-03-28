<?php

namespace App\Filament\Resources\Prisoners\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PrisonersForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                DatePicker::make('birth_date'),
                DatePicker::make('admission_date')
                    ->required(),
                TextInput::make('offense')
                    ->required(),
                TextInput::make('assigned_cell')
                    ->required(),
            ]);
    }
}
