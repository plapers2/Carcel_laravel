<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('identification_number')
                    ->label('Identification Number')
                    ->required()
                    ->maxLength(20)
                    ->rule('regex:/^[0-9]+$/')
                    ->inputMode('numeric'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->password()
                    ->required(),
                Select::make('rol_id')
                    ->label('Rol')
                    ->relationship('rol', 'name')
                    ->searchable()
                    ->preload()
                    ->default(null),
            ]);
    }
}
