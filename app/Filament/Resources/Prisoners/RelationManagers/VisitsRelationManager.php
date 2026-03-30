<?php

namespace App\Filament\Resources\PrisioneroResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class VisitasRelationManager extends RelationManager
{
    protected static string $relationship = 'visits';

    public function table(Table $table): Table
    {

        return $table
            ->defaultSort('start_date', 'desc')
            ->columns([
                TextColumn::make('visitor.name')
                    ->searchable()
                    ->label('Visitante'),

                TextColumn::make('visitor_relationship')
                    ->searchable()
                    ->label('Relación'),

                TextColumn::make('start_date')
                    ->dateTime()
                    ->searchable()
                    ->label('Inicio'),

                TextColumn::make('end_date')
                    ->dateTime()
                    ->searchable()
                    ->label('Fin'),

                TextColumn::make('verification')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Terminada' => 'success',
                        'En curso' => 'warning',
                        'Desaprobada' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('verification')
                    ->label('Estado')
                    ->options([
                        'Terminada' => 'Terminada',
                        'En curso' => 'En curso',
                        'Desaprobada' => 'Desaprobada',
                    ])
            ]);
    }
}
