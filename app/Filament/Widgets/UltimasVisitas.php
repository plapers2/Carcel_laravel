<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Models\visits;

class UltimasVisitas extends BaseWidget
{
    protected static ?string $heading = 'Últimas visitas';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                visits::query()->latest()->limit(5)
            )
            ->columns([
                TextColumn::make('visitor.name')
                    ->label('Visitante')
                    ->searchable(),

                TextColumn::make('prisoner.name')
                    ->label('Prisionero')
                    ->searchable(),

                TextColumn::make('start_date')
                    ->label('Fecha')
                    ->dateTime(),

                TextColumn::make('verification')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'aprobada' => 'success',
                        'rechazada' => 'danger',
                        'pendiente' => 'warning',
                        default => 'gray',
                    }),
            ]);
    }
}
