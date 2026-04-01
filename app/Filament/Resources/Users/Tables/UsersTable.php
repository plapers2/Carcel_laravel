<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('identification_number')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->wrap()
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->wrap()
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('rol.name')
                    ->wrap()
                    ->label('Rol')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->wrap()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->wrap()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
