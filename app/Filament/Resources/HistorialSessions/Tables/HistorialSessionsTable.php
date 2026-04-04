<?php

namespace App\Filament\Resources\HistorialSessions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HistorialSessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->wrap()
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->wrap()
                    ->searchable()
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('finish_date')
                    ->wrap()
                    ->dateTime()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ip')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('user_agent')
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
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
