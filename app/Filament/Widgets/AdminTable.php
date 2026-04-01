<?php

namespace App\Filament\Widgets;

use App\Models\visits;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\TextColumn;

class AdminTable extends TableWidget
{
    protected static bool $isDiscovered = false;
    protected static ?string $heading = 'Latest Visits';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                visits::query()->latest()->limit(5)
            )
            ->columns([
                TextColumn::make('visitor.name')
                    ->label('Visitor')
                    ->searchable(),

                TextColumn::make('prisoner.name')
                    ->label('Prisoner')
                    ->searchable(),

                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->dateTime(),

                TextColumn::make('verification')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'Pending' => 'warning',
                        'Approved' => 'info',
                        'In progress' => 'primary',
                        'Finished' => 'success',
                        'Rejected' => 'danger',
                        default => 'gray',
                    }),
            ]);
    }
}
