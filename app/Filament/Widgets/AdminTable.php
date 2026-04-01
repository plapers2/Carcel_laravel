<?php

namespace App\Filament\Widgets;

use App\Models\visits;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
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
                    ->wrap()
                    ->searchable(),

                TextColumn::make('prisoner.name')
                    ->label('Prisoner')
                    ->wrap()
                    ->searchable(),

                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->wrap()
                    ->dateTime(),

                TextColumn::make('verification')
                    ->badge()
                    ->wrap()
                    ->icon(fn(string $state): string => match ($state) {
                        'Pending'     => 'heroicon-o-clock',
                        'Approved'     => 'heroicon-o-check-circle',
                        'In progress' => 'heroicon-o-arrow-path',
                        'Finished'    => 'heroicon-o-check-badge',
                        'Rejected'    => 'heroicon-o-x-circle',
                        default       => 'heroicon-o-question-mark-circle',
                    })
                    ->color(fn(string $state) => match ($state) {
                        'Pending' => 'warning',
                        'Approved' => 'info',
                        'In progress' => 'primary',
                        'Finished' => 'success',
                        'Rejected' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('verification')
                    ->options([
                        'Pending' => 'Pending',
                        'Approve' => 'Approved',
                        'In progress' => 'In Progress',
                        'Finished' => 'Finished',
                        'Rejected' => 'Rejected',
                    ]),
                Filter::make('today')
                    ->label('Today only')
                    ->query(fn($query) => $query->whereDate('start_date', today())),
            ]);
    }
}
