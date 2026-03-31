<?php

namespace App\Filament\Resources\HistorialSessions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class HistorialSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('start_date')
                    ->required(),
                DateTimePicker::make('finish_date'),
                TextInput::make('ip')
                    ->default(null),
                TextInput::make('user_agent')
                    ->default(null),
            ]);
    }
}
