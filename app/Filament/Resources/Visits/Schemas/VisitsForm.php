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
                    ->minDate(now())
                    ->time()
                    ->hiddenOn('edit')
                    ->rules([
                        fn() =>
                        function (string $attribute, mixed $value, Closure $fail) {
                            if (Carbon::parse($value)->dayOfWeek !== Carbon::SUNDAY) {
                                $fail('Visits are only allowed on Sundays!');
                            }
                        },
                        fn() => function (string $attribute, $value, \Closure $fail) {
                            $hour = \Carbon\Carbon::parse($value)->hour;
                            if ($hour < 14 || $hour >= 17) {
                                $fail('Visits are only allowed between 14:00 and 17:00!');
                            }
                        }
                    ]),
                Select::make('verification')
                    ->label('State')
                    ->hiddenOn('create')
                    ->options(['Rejected' => 'Rejected', 'Finished' => 'Finished'])
                    ->required(),
                Select::make('prisoners_id')
                    ->label('Prisoner')
                    ->relationship('prisoner', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->hiddenOn('edit'),
                Select::make('visitors_id')
                    ->label('Visitor')
                    ->relationship('visitor', 'name')
                    ->searchable()
                    ->preload()
                    ->hiddenOn('edit')
                    ->required(),
            ]);
    }
}
