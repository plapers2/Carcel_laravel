<?php

namespace App\Filament\Resources\Visits\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VisitsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('visitor_relationship')
                    ->required(),
                DateTimePicker::make('start_date')
                    ->required(),
                DateTimePicker::make('end_date')
                    ->required(),
                Select::make('verification')
                    ->label('Estado')
                    ->options(['En curso' => 'En curso', 'Desaprobada' => 'Desaprobada', 'Terminada' => 'Terminada'])
                    ->required(),
                Select::make('prisoners_id')
                    ->label('Prisionero')
                    ->relationship('prisoner', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('visitors_id')
                    ->label('Visitante')
                    ->relationship('visitor', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('users_id')
                    ->label('Guardia / Usuario')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
