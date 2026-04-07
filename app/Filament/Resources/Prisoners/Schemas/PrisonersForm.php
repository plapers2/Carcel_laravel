<?php

namespace App\Filament\Resources\Prisoners\Schemas;

use Carbon\Carbon;
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
                DatePicker::make('birth_date')
                    ->required()
                    ->maxDate(now()->subYears(18))
                    ->rules([
                        'before_or_equal:' . now()->subYears(18)->toDateString(),
                    ])
                    ->validationMessages([
                        'before_or_equal' => 'The age must be bigger or equal that 18 years old.',
                    ])
                    ->reactive(),
                DatePicker::make('admission_date')
                    ->required()
                    ->minDate(
                        fn($get) =>
                        $get('birth_date')
                            ? Carbon::parse($get('birth_date'))->addYears(18)
                            : null
                    )
                    ->maxDate(now())
                    ->validationMessages([
                        'min_date' => 'The admission date must be at least 18 years after the birthdate.',
                        'max_date' => 'The admission date must not be a future date that now',
                    ]),
                TextInput::make('offense')
                    ->required(),
                TextInput::make('assigned_cell')
                    ->required(),
            ]);
    }
}
