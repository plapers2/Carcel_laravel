<?php

namespace App\Filament\Resources\PrisioneroResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions;

use App\Exports\VisitasExport;
use Maatwebsite\Excel\Facades\Excel;

class VisitasRelationManager extends RelationManager
{
    protected static string $relationship = 'visits';

    protected static ?string $title = 'Visit History';

    public static function canViewForRecord($ownerRecord, string $pageClass): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('start_date', 'desc')

            ->columns([
                TextColumn::make('visitor.name')
                    ->label('Visitor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('visitor_relationship')
                    ->label('Relationship')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Start')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('End')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('In progress')
                    ->sortable(),

                TextColumn::make('verification')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn(?string $state) => match ($state) {
                        'Pending' => 'Pending',
                        'Approved' => 'Approved',
                        "Finished" => 'Finished',
                        'Rejected' => 'Rejected',
                        "In progress" => "In Progress",
                        default => 'Unknown',
                    })
                    ->color(fn(?string $state): string => match ($state) {
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
                    ->label('Status')
                    ->options([
                        'Pending' => 'Pending',
                        'Approved' => 'Approved',
                        "Finished" => 'Finished',
                        'Rejected' => 'Rejected',
                        "In progress" => "In progress"
                    ]),

                Filter::make('date')
                    ->label('Date range')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('to'),
                    ])
                    ->query(
                        fn($query, array $data) =>
                        $query
                            ->when($data['from'] ?? null, fn($q, $date) => $q->whereDate('start_date', '>=', $date))
                            ->when($data['to'] ?? null, fn($q, $date) => $q->whereDate('start_date', '<=', $date))
                    ),
            ]);
    }
}
