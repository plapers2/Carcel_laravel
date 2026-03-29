<?php

namespace App\Filament\Resources\Visits\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Carbon\Carbon;
use Closure;

class VisitsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('visitor_relationship')
                    ->required()
                    ->hiddenOn('edit'),
                DateTimePicker::make('start_date')
                    ->required()
                    ->hiddenOn('edit')
                    ->rules([
                        function () {
                            return function (string $attribute, mixed $value, Closure $fail) {
                                if (Carbon::parse($value)->dayOfWeek !== Carbon::SUNDAY) {
                                    $fail('Las visitas solo se permiten los domingos.');
                                }
                            };
                        }
                    ]),
                Select::make('verification')
                    ->label('Estado')
                    ->hiddenOn('create')
                    ->options(['Desaprobada' => 'Desaprobada', 'Terminada' => 'Terminada'])
                    ->required(),
                Select::make('prisoners_id')
                    ->label('Prisionero')
                    ->relationship('prisoner', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->hiddenOn('edit'),
                Select::make('visitors_id')
                    ->label('Visitante')
                    ->relationship('visitor', 'name')
                    ->searchable()
                    ->preload()
                    ->hiddenOn('edit')
                    ->required(),
            ]);
    }
}
