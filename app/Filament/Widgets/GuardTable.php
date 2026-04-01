<?php

namespace App\Filament\Widgets;

use App\Models\visits as ModelsVisits;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Facades\Auth;

class GuardTable extends TableWidget
{
    protected static bool $isDiscovered = false;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                ModelsVisits::query()
                    ->where('users_id', Auth::id())
                    ->latest()
                    ->limit(5)
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
