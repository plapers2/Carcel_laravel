<?php

namespace App\Filament\Resources\Users\Schemas;


use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;


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
                    ->inputMode('numeric')
                    ->unique(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn($state) => filled($state)) // Evita sobrescribir en vacio
                    ->required(fn(string $operation) => $operation === 'create'), // solo en create
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->preload()
                    ->searchable()
            ]);
    }
}
