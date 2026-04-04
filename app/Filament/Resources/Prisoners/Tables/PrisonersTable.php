<?php

namespace App\Filament\Resources\Prisoners\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PrisonersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('birth_date')
                    ->wrap()
                    ->date()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('admission_date')
                    ->wrap()
                    ->date()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('offense')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('assigned_cell')
                    ->wrap()
                    ->searchable(),
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
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
